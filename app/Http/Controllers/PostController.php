<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //post details with category and author from admin table 
    public function postDetials($slug)
    {
        $post = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('admins', 'posts.author_id', '=', 'admins.id')
            ->select('posts.*', 'categories.name as category_name', 'admins.name as author_name')
            ->where('posts.slug', $slug)
            ->first();

        if (!$post) {
            abort(404);
        }

        return view('post.details', compact('post'));
    }
    
    

}
