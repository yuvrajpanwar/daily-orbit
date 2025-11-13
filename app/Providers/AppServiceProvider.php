<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // RedirectIfAuthenticated::
        View::composer('layouts.app', function ($view) {
            $view->with('categories', Category::select('name')->where('is_deleted', 0)->where('is_active', 1)->get());
        });
    }
}
