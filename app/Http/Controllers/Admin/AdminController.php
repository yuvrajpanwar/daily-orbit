<?php
namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function index()
    {
        $totalPosts = Post::where('is_deleted',0)->count();
        $totalCategories = Category::where('is_deleted',0)->count();
        $totalAuthors = Author::where('is_deleted',0)->count();

        return view('admin.dashboard', compact('totalPosts', 'totalCategories', 'totalAuthors'));
    }
    public function categories()
    {
        return view('admin.categories.categories');
    }
    public function posts()
    {
        return view('admin.posts.posts');
    }
    public function authors()
    {
        return view('admin.authors.authors');
    }
}
