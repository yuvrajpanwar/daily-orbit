<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function categories()
    {
        return view('admin.categories.categories');
    }
}
