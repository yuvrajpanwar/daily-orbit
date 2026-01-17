<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'thumbnail',
        'slug',
        'title',
        'description',
        'time',
        'is_published',
        'is_deleted',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_deleted' => 'boolean',
        'time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                // Detect if title contains Hindi (Devanagari) characters
                if (preg_match('/[\x{0900}-\x{097F}]/u', $post->title)) {
                    // Generate Hindi slug (keep Hindi chars, replace spaces/symbols)
                    $baseSlug = trim(preg_replace('/[^\p{Devanagari}\p{N}\s-]+/u', '', $post->title)); // keep only Hindi, numbers, spaces, and dashes
                    $baseSlug = preg_replace('/\s+/u', '-', $baseSlug); // spaces → dashes
                    $baseSlug = preg_replace('/-+/', '-', $baseSlug); // collapse multiple dashes
                } else {
                    // For English or Latin text, use Laravel's slug helper
                    $baseSlug = Str::slug($post->title);
                }

                $slug = $baseSlug;
                $counter = 1;

                // Ensure uniqueness
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $post->slug = $slug;
            }
        });
    }


    // Relationship with Admin (author)
    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Get thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return Storage::disk('public')->url($this->thumbnail);
        }
        return null;
    }

    // Get all posts
    public static function getAllPosts()
    {
        return self::where('is_deleted', 0)
            ->where('is_published', 1)
            ->orderBy('time', 'desc')
            ->get();
    }

    // Get post by slug
    public static function getPostBySlug($slug)
    {
        return self::where('slug', $slug)
            ->where('is_deleted', 0)
            ->where('is_published', 1)
            ->firstOrFail();
    }

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('is_published', 1)
            ->where('is_deleted', 0)
            ->where('time', '<=', now());
    }

    // Scope for active posts (alias for published)
    public function scopeActive($query)
    {
        return $this->scopePublished($query);
    }

    // In Post model
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

}
