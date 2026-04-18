<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\GoogleIndexingService;
use Illuminate\Support\Facades\Log;

/**
 * PostObserver
 *
 * Automatically pings Google and Bing whenever a post is:
 *  - Published (created or updated with is_published = 1)
 *  - Unpublished / Deleted
 *
 * Register this in: App\Providers\AppServiceProvider (or EventServiceProvider)
 */
class PostObserver
{
    private GoogleIndexingService $indexing;

    public function __construct(GoogleIndexingService $indexing)
    {
        $this->indexing = $indexing;
    }

    /**
     * Fires after a post is CREATED
     */
    public function created(Post $post): void
    {
        if ($post->is_published && !$post->is_deleted) {
            $this->pingAll($post, 'CREATED');
        }
    }

    /**
     * Fires after a post is UPDATED
     */
    public function updated(Post $post): void
    {
        $url = $this->postUrl($post);

        // If post was just PUBLISHED (flipped from 0 → 1)
        if ($post->wasChanged('is_published') && $post->is_published && !$post->is_deleted) {
            Log::info("PostObserver: Post published → {$url}");
            $this->pingAll($post, 'PUBLISHED');
            return;
        }

        // If post was UNPUBLISHED or DELETED → notify Google to remove
        if ($post->wasChanged('is_published') && !$post->is_published) {
            Log::info("PostObserver: Post unpublished → {$url}");
            $this->indexing->notifyDeleted($url);
            return;
        }

        if ($post->wasChanged('is_deleted') && $post->is_deleted) {
            Log::info("PostObserver: Post deleted → {$url}");
            $this->indexing->notifyDeleted($url);
            return;
        }

        // If content changed on an already-published post → re-ping as updated
        if ($post->is_published && !$post->is_deleted && $post->wasChanged(['title', 'description', 'slug', 'thumbnail'])) {
            Log::info("PostObserver: Post content updated → {$url}");
            $this->pingAll($post, 'UPDATED');
        }
    }

    /**
     * Fires after a post is DELETED (hard delete)
     */
    public function deleted(Post $post): void
    {
        $url = $this->postUrl($post);
        Log::info("PostObserver: Post hard-deleted → {$url}");
        $this->indexing->notifyDeleted($url);
    }

    /**
     * Ping both Google Indexing API and Bing IndexNow
     */
    private function pingAll(Post $post, string $reason): void
    {
        $url = $this->postUrl($post);

        // Ping Google (requires service account setup)
        $this->indexing->notifyUpdated($url);

        // Ping Bing/IndexNow (just needs an API key in .env)
        $this->indexing->pingIndexNow($url);

        Log::info("PostObserver: [{$reason}] Pinged all search engines → {$url}");
    }

    private function postUrl(Post $post): string
    {
        return url("/post/{$post->slug}");
    }
}