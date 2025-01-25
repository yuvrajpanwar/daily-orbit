<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'author',
        'type',
        'image',
        'video',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $baseSlug = Str::slug($post->title);
                $slug = $baseSlug;
                $counter = 1;
    
                // Keep checking until we find a unique slug
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
    
                $post->slug = $slug;
            }
        });
    }

    // Get all posts
    public static function getAllPosts()
    {
        return self::orderBy('date', 'desc')->get();
    }

    // Get post by slug
    public static function getPostBySlug($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
