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
}
