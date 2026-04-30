<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function show($id)
    {
        $author = DB::table('admins')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->select('id', 'name', 'about', 'profile_picture', 'type')
            ->first();

        if (!$author) {
            abort(404, 'Author not found');
        }

        // Initial 5 posts
        $posts = $this->getAuthorPosts($author->id, 5);

        return view('author.show', compact('author', 'posts'));
    }

    public function loadMore($id, Request $request)
    {
        $author = DB::table('admins')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->select('id')
            ->first();

        if (!$author) {
            return response()->json([], 404);
        }

        $page    = $request->get('page', 1);
        $perPage = 5;
        $offset  = ($page - 1) * $perPage;

        $posts = DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'posts.description',
                'posts.time',
                'admins.name as author_name',
                DB::raw('COALESCE(post_views.min_views, 0) + COALESCE(post_views.actual_views, 0) as total_views')
            )
            ->where('posts.author_id', $author->id)
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('posts.time')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $posts = $posts->map(function ($post) {
            $post->title   = Str::limit($post->title, 200, '...');
            $post->excerpt = Str::limit(strip_tags($post->description), 200, '...');
            $post->image   = asset('storage/' . $post->thumbnail);
            $post->post_url = route('post.details', $post->slug);
            $post->date    = \Carbon\Carbon::parse($post->time)->format('M d, Y');
            return $post;
        });

        return response()->json($posts);
    }

    private function getAuthorPosts($authorId, $limit = 5)
    {
        return DB::table('posts')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select(
                'posts.id',
                'posts.slug',
                'posts.title',
                'posts.thumbnail',
                'posts.description',
                'posts.time',
                'admins.name as author_name',
                DB::raw('COALESCE(post_views.min_views, 0) + COALESCE(post_views.actual_views, 0) as total_views')
            )
            ->where('posts.author_id', $authorId)
            ->where('posts.is_published', 1)
            ->where('posts.is_deleted', 0)
            ->orderByDesc('posts.time')
            ->limit($limit)
            ->get()
            ->map(function ($post) {
                $post->title   = Str::limit($post->title, 200, '...');
                $post->excerpt = Str::limit(strip_tags($post->description), 200, '...');
                $post->image   = asset('storage/' . $post->thumbnail);
                $post->post_url = route('post.details', $post->slug);
                $post->date    = \Carbon\Carbon::parse($post->time)->format('M d, Y');
                return $post;
            });
    }
}