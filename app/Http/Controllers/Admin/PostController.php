<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            //for searching 
            ->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('posts.title', 'like', '%' . $searchValue . '%')
                    ->orWhere('posts.author', 'like', '%' . $searchValue . '%')
                    ->orWhere('posts.date', 'like', '%' . $searchValue . '%');
            });
        $query->where('is_deleted', 0)->orderBy('posts.id', 'DESC');
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                return ucFirst($row->title);
            })
            ->addColumn('author', function ($row) {
                return ucFirst($row->author);
            })
            ->addColumn('date', function ($row) {
                return Carbon::parse($row->date)->format('d/m/Y');
            })

            ->make(true);
    }


    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->author = $request->author;
        $post->date = $request->date;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Handle video URL
        if ($request->video) {
            $post->video = $request->video;
        }

        $post->save();

        return redirect()->route('admin.posts')
            ->with('success', 'Post created successfully');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store directly in public/uploads/posts directory
            $file->move(public_path('uploads/posts'), $filename);

            return response()->json([
                'success' => true,
                'url' => asset('uploads/posts/' . $filename)
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
            'author' => 'required|string|max:255',
            'type' => 'required|in:video,image',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string'
        ]);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->author = $request->author;
        $post->type = $request->type;
        $post->date = $request->date;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Handle video URL
        if ($request->video) {
            $post->video = $request->video;
        }

        $post->save();

        return redirect()->route('fetch-all-posts')
            ->with('success', 'Post updated successfully');
    }

    public function updatePostVisibility(Post $post)
    {
        $post->is_active = !$post->is_active;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post visibility updated successfully',
            'is_active' => $post->is_active
        ]);
    }

    public function deletePost(Post $post)
    {
        // Soft delete
        $post->is_deleted = 1;
        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }
}
