<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveAllPostImages extends Command
{
    protected $signature = 'blog:remove-images';
    protected $description = 'Remove all images from blog posts';

    public function handle()
    {
        $this->info('Removing images from all blog posts...');
        
        // Get count of posts with images
        $count = DB::table('posts')
            ->whereNotNull('featured_image')
            ->count();
        
        // Update all posts to remove featured_image
        DB::table('posts')
            ->update(['featured_image' => null]);
        
        $this->info("Successfully removed images from {$count} posts.");
        
        return Command::SUCCESS;
    }
}