<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Post;

class PostController extends Controller
{
    //post details with category and author from admin table 
    public function postDetials($slug)
    {
        $post = Post::query()
            ->with([
                'category',           // → $post->category->name
                'author',             // → $post->author->name
                'comments.user'       // eager load only the users for comments
            ])
            ->withCount('comments')   // ← adds $post->comments_count (real total count)
            ->where('slug', $slug)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->firstOrFail();

        // Optional: limit displayed comments to newest 5–6 (performance)
        $post->setRelation(
            'comments',
            $post->comments->take(6)->sortByDesc('created_at')
        );

        if (!$post) {
            abort(404);
        }

        // === View Count Logic ===
        $postId = $post->id;
        $sessionKey = "post_viewed_{$postId}";

        // Get or create view record
        $views = DB::table('post_views')
            ->where('post_id', $postId)
            ->first();

        // If no view row exists, create one with random min_views
        if (!$views) {
            $minViews = rand(10, 100);
            DB::table('post_views')->insert([
                'post_id' => $postId,
                'min_views' => $minViews,
                'actual_views' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $totalViews = $minViews;
        } else {
            $totalViews = $views->min_views + $views->actual_views;

            // Only increment actual_views if not viewed in this session
            if (!Session::has($sessionKey)) {
                DB::table('post_views')
                    ->where('post_id', $postId)
                    ->increment('actual_views');

                Session::put($sessionKey, true); // Mark as viewed
                $totalViews++; // Reflect the increment
            }
        }

        // Attach total views to post object
        $post->total_views = $totalViews;


       // === Similar Posts: Strict Priority (Same Category First, Latest First) ===
        $categoryId = $post->category_id;
        $postId = $post->id;

        // 1. Get up to 5 LATEST from SAME category
        $sameCategoryPosts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'categories.name as category_name',
                'admins.name as author_name',
                'posts.created_at'
            )
            ->where('posts.category_id', $categoryId)
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->where('posts.id', '!=', $postId)
            ->orderBy('posts.created_at', 'desc')  // LATEST first
            ->limit(5)
            ->get();

        $needed = 5 - $sameCategoryPosts->count();

        // 2. Fill remaining with LATEST from OTHER categories
        $otherPosts = collect();
        if ($needed > 0) {
            $otherPosts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('admins', 'posts.author_id', '=', 'admins.id')
                ->select(
                    'posts.id',
                    'posts.slug',
                    'posts.title',
                    'posts.thumbnail',
                    'categories.name as category_name',
                    'admins.name as author_name',
                    'posts.created_at'
                )
                ->where('posts.category_id', '!=', $categoryId)
                ->where('posts.is_published', 1)
                ->where('posts.is_deleted', 0)
                ->where('posts.id', '!=', $postId)
                ->orderBy('posts.created_at', 'desc')  // LATEST first
                ->limit($needed)
                ->get();
        }

        // Merge and trim titles
        $similarPosts = $sameCategoryPosts->merge($otherPosts)->map(function ($item) {
            $item->title = Str::limit($item->title, 50, '...');
            return $item;
        });

        return view('post.details', compact('post'));
    }
    


    public function popularPosts()
    {
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'admins.name as author_name',
                DB::raw('COALESCE(post_views.actual_views, 0) + COALESCE(post_views.min_views, 0) as total_views'),
                'posts.created_at'
            )
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('total_views')  // Most viewed
            ->orderByDesc('posts.created_at') // Then newest
            ->limit(3)
            ->get();

        // Format response
        $posts = $posts->map(function ($post) {
            $post->title = Str::limit($post->title, 60, '...');
            $post->time_ago = \Carbon\Carbon::parse($post->created_at)->diffForHumans();
            $post->image = asset('storage/' . $post->thumbnail);
            return $post;
        });

        return response()->json($posts);
    }



    public function similarPostsAjax($slug)
    {
        // 1. Find the current post (only need id & category)
        $current = DB::table('posts')
            ->select('id', 'category_id')
            ->where('slug', $slug)
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->first();

        if (!$current) {
            return response()->json([], 404);
        }

        $categoryId = $current->category_id;
        $postId     = $current->id;

        // 2. SAME CATEGORY – latest first
        $same = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'categories.name as category_name',
                'admins.name as author_name',
                'posts.created_at'
            )
            ->where('posts.category_id', $categoryId)
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->where('posts.id', '!=', $postId)
            ->orderByDesc('posts.created_at')
            ->limit(5)
            ->get();

        $needed = 5 - $same->count();

        // 3. OTHER CATEGORIES – fill remainder
        $others = collect();
        if ($needed > 0) {
            $others = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('admins', 'posts.author_id', '=', 'admins.id')
                ->select(
                    'posts.id',
                    'posts.slug',
                    'posts.title',
                    'posts.thumbnail',
                    'categories.name as category_name',
                    'admins.name as author_name',
                    'posts.created_at'
                )
                ->where('posts.category_id', '!=', $categoryId)
                ->where('posts.is_published', 1)
                ->where('posts.is_deleted', 0)
                ->where('posts.id', '!=', $postId)
                ->orderByDesc('posts.created_at')
                ->limit($needed)
                ->get();
        }

        // 4. Merge + format
        $posts = $same->merge($others)->map(function ($p) {
            $p->title      = Str::limit($p->title, 50, '...');
            $p->image      = asset('storage/' . $p->thumbnail);
            $p->time_ago   = \Carbon\Carbon::parse($p->created_at)->diffForHumans();
            $p->post_url   = route('post.details', $p->slug);
            return $p;
        });

        return response()->json($posts);
    }



    public function trendingPosts()
    {
        $posts = DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'posts.description',
                'admins.name as author_name',
                'posts.created_at',
                DB::raw('COALESCE(post_views.min_views, 0) + COALESCE(post_views.actual_views, 0) as total_views')
            )
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('total_views')
            ->orderByDesc('posts.created_at') // tie-breaker
            ->limit(2)
            ->get();

        $posts = $posts->map(function ($post) {
            $post->title       = Str::limit($post->title, 70, '...');
            $post->excerpt     = Str::limit(strip_tags($post->description), 120, '...');
            $post->image       = asset('storage/' . $post->thumbnail);
            $post->post_url    = route('post.details', $post->slug);
            $post->time_ago    = \Carbon\Carbon::parse($post->created_at)->format('M d, Y');
            return $post;
        });

        return response()->json($posts);
    }




    public function mostRecentPosts()
    {
        $posts = DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'admins.name as author_name',
                'posts.created_at'
            )
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('posts.created_at')
            ->limit(3)
            ->get();

        $posts = $posts->map(function ($post, $index) {
            $post->title     = Str::limit($post->title, $index === 0 ? 60 : 70, '...');
            $post->image     = asset('storage/' . $post->thumbnail);
            $post->post_url  = route('post.details', $post->slug);
            $post->time_ago  = \Carbon\Carbon::parse($post->created_at)->diffForHumans();
            $post->is_first  = $index === 0;
            return $post;
        });

        return response()->json($posts);
    }


    public function mostPopularPosts()
    {
        $posts = DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'admins.name as author_name',
                'posts.created_at',
                DB::raw('COALESCE(post_views.min_views, 0) + COALESCE(post_views.actual_views, 0) as total_views')
            )
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('total_views')
            ->orderByDesc('posts.created_at')
            ->limit(5)
            ->get();

        $posts = $posts->map(function ($post) {
            $post->title     = Str::limit($post->title, 70, '...');
            $post->image     = asset('storage/' . $post->thumbnail);
            $post->post_url  = route('post.details', $post->slug);
            $post->date      = \Carbon\Carbon::parse($post->created_at)->format('d M Y');
            return $post;
        });

        return response()->json($posts);
    }





    public function youMightLikePosts()
    {
        // Get 4 random published posts (excluding current if needed)
        $posts = DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'admins.name as author_name',
                'posts.created_at'
            )
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $posts = $posts->map(function ($post) {
            $post->title     = Str::limit($post->title, 60, '...');
            $post->image     = asset('storage/' . $post->thumbnail);
            $post->post_url  = route('post.details', $post->slug);
            $post->time_ago  = \Carbon\Carbon::parse($post->created_at)->diffForHumans();
            return $post;
        });

        return response()->json($posts);
    }


}
