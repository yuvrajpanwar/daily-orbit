<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = \App\Models\Category::select('name')->where('is_deleted', 0)->where('is_active', 1)->get();
        // dd($categories);
        // count of categories
        // dd($categories->count());
        return view('home');
    }
}
