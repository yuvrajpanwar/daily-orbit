<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SitemapController extends Controller
{
    /**
     * Main sitemap index — lists all sub-sitemaps
     * URL: /sitemap.xml
     */
    public function index()
    {
        $sitemaps = [
            [
                'loc'     => url('/sitemap-static.xml'),
                'lastmod' => Carbon::now()->toAtomString(),
            ],
            [
                'loc'     => url('/sitemap-posts.xml'),
                'lastmod' => optional(
                    Post::published()->latest('updated_at')->first()
                )->updated_at?->toAtomString() ?? Carbon::now()->toAtomString(),
            ],
            [
                'loc'     => url('/sitemap-categories.xml'),
                'lastmod' => Carbon::now()->toAtomString(),
            ],
        ];

        return response()
            ->view('sitemaps.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Static pages sitemap
     * URL: /sitemap-static.xml
     */
    public function staticPages()
    {
        $pages = [
            ['loc' => url('/'),                    'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => url('/about'),               'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => url('/contact-us'),          'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => url('/privacy-policy'),      'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => url('/terms-and-conditions'),'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        return response()
            ->view('sitemaps.static', compact('pages'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * All published posts sitemap — DYNAMIC, auto-updates
     * URL: /sitemap-posts.xml
     */
    public function posts()
    {
        // Fetch all published posts — only the columns we need (fast query)
        $posts = DB::table('posts')
            ->select('slug', 'updated_at', 'created_at', 'title')
            ->where('is_published', 1)
            ->where('is_deleted', 0)
            ->whereNotNull('slug')
            ->orderByDesc('updated_at')
            ->get();

        return response()
            ->view('sitemaps.posts', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Categories sitemap
     * URL: /sitemap-categories.xml
     */
    public function categories()
    {
        $categories = DB::table('categories')
            ->select('name', 'updated_at')
            ->get();

        return response()
            ->view('sitemaps.categories', compact('categories'))
            ->header('Content-Type', 'application/xml');
    }
}