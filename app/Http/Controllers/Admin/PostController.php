<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function addPost()
    {
        $categories = Category::where('is_deleted', 0)->orderBy('name')->get();
        return view('admin.posts.add-post', compact('categories'));
    }

    public function fetchAllPosts(Request $request)
    {
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'];
        $query = Post::select('posts.*')
            ->with(['author', 'category'])
            //for searching 
            ->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('posts.title', 'like', '%' . $searchValue . '%')
                    ->orWhere('posts.time', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('author', function($q) use ($searchValue) {
                        $q->where('name', 'like', '%' . $searchValue . '%');
                    });
            });
        $query->where('is_deleted', 0)->orderBy('posts.id', 'DESC');
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                return ucFirst($row->title);
            })
            ->addColumn('author', function ($row) {
                return $row->author ? ucFirst($row->author->name) : 'N/A';
            })
            ->addColumn('category', function ($row) {
                return $row->category ? ucFirst($row->category->name) : 'N/A';
            })
            ->addColumn('time', function ($row) {
                // Format: dd-mm-yyyy | hh:mm AM/PM
                return Carbon::parse($row->time)->format('d/m/y h:i A');
            })
            ->addColumn('is_published', function ($row) {
                return $row->is_published ? 'Published' : 'Draft';
            })
            ->make(true);
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'time' => 'required|date',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $post = new Post();
        $post->title = $request->title;
        $post->description = $this->cleanDescription($request->description);
        $post->category_id = $request->category_id;
        $post->author_id = Auth::guard('only-admin')->id(); // Automatically use logged-in user as author
        $post->time = $request->time;
        $post->is_published = 0; // Set as not published
        $post->is_deleted = 0; // Set as not deleted

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts/thumbnails', 'public');
            $post->thumbnail = $thumbnailPath; 
        }
    
        $post->save();
    
        return redirect()->route('admin.posts')
            ->with('success', 'Post created successfully');
    }
    

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Store in storage/app/public/posts/inline-images directory
            $path = $file->storeAs('posts/inline-images', $filename, 'public');

            // Return the URL that can be accessed via the symbolic link
            $url = Storage::disk('public')->url($path);

            return response()->json([
                'success' => true,
                'url' => $url
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image provided'
        ], 400);
    }

    public function editPost(Post $post)
    {
        $categories = Category::where('is_deleted', 0)->orderBy('name')->get();
        return view('admin.posts.edit-post', compact('post', 'categories'));
    }

    public function updatePost(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'time' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->title = $request->title;
        $post->description = $this->cleanDescription($request->description);
        $post->category_id = $request->category_id;
        $post->time = $request->time;

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('posts/thumbnails', 'public');
            $post->thumbnail = $thumbnailPath;
        }

        $post->save();

        return redirect()->route('admin.posts')
            ->with('success', 'Post updated successfully');
    }

    public function updatePostVisibility(Post $post)
    {
        $post->is_published = !$post->is_published;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post visibility updated successfully',
            'is_published' => $post->is_published
        ]);
    }

    public function deletePost(Post $post)
    {
        // Delete associated images before soft deleting
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        // Soft delete
        $post->is_deleted = 1;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * Clean description by removing base64 encoded images
     */
    private function cleanDescription($description)
    {
        // Remove base64 encoded images
        $description = preg_replace('/<img[^>]+src="data:image\/[^;]+;base64,[^"]*"[^>]*>/i', '', $description);
        
        // Remove empty paragraphs that might be left after removing images
        $description = preg_replace('/<p>\s*<\/p>/i', '', $description);
        
        // Clean up multiple consecutive line breaks
        $description = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '<br>', $description);
        
        return $description;
    }
}
