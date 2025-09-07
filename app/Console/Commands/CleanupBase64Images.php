<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class CleanupBase64Images extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:cleanup-base64-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up base64 encoded images from post descriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of base64 images from post descriptions...');

        $posts = Post::where('description', 'like', '%data:image/%')->get();
        
        if ($posts->isEmpty()) {
            $this->info('No posts with base64 images found.');
            return 0;
        }

        $this->info("Found {$posts->count()} posts with base64 images.");

        $bar = $this->output->createProgressBar($posts->count());
        $bar->start();

        foreach ($posts as $post) {
            $originalDescription = $post->description;
            
            // Clean the description
            $cleanedDescription = $this->cleanDescription($originalDescription);
            
            // Update the post if description changed
            if ($cleanedDescription !== $originalDescription) {
                $post->description = $cleanedDescription;
                $post->save();
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Cleanup completed successfully!');

        return 0;
    }

    /**
     * Clean description by removing base64 encoded images
     */
    private function cleanDescription($description)
    {
        // Remove base64 encoded images
        $description = preg_replace('/<img[^>]+src="data:image\/[^;]+;base64,[^"]*"[^>]*>/i', '', $description);
        
        // Remove empty paragraphs that might be left after removing images
        $description = preg_replace('/<p>\s*<\/p>/i', '', $description);
        
        // Clean up multiple consecutive line breaks
        $description = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '<br>', $description);
        
        return $description;
    }
}
