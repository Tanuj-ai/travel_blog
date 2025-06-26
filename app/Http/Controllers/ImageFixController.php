<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageFixController extends Controller
{
    public function fixImages()
    {
        // Only allow in local environment
        if (app()->environment() !== 'local') {
            return response()->json(['message' => 'This action is only available in the local environment'], 403);
        }
        
        $posts = DB::table('posts')->get();
        $fixed = 0;
        $errors = [];
        
        foreach ($posts as $post) {
            if ($post->featured_image) {
                // Check if the image exists
                if (!Storage::disk('public')->exists($post->featured_image)) {
                    // Image doesn't exist, set a default based on the post title
                    $newImagePath = $this->getDefaultImageForPost($post);
                    
                    DB::table('posts')
                        ->where('id', $post->id)
                        ->update(['featured_image' => $newImagePath]);
                    
                    $fixed++;
                    $errors[] = "Fixed post ID {$post->id}: {$post->title}";
                }
            } else {
                // No image set, let's download one from Unsplash
                $newImagePath = $this->downloadUnsplashImage($post);
                
                if ($newImagePath) {
                    DB::table('posts')
                        ->where('id', $post->id)
                        ->update(['featured_image' => $newImagePath]);
                    
                    $fixed++;
                    $errors[] = "Added image for post ID {$post->id}: {$post->title}";
                }
            }
        }
        
        return response()->json([
            'message' => "Fixed {$fixed} posts with missing images",
            'details' => $errors
        ]);
    }
    
    private function getDefaultImageForPost($post)
    {
        // Check post title for keywords and assign appropriate default image
        $title = strtolower($post->title);
        
        if (str_contains($title, 'northern lights') || 
            str_contains($title, 'aurora') || 
            str_contains($title, 'iceland')) {
            return 'posts/northern-lights.jpg';
        }
        
        if (str_contains($title, 'beach') || 
            str_contains($title, 'ocean') || 
            str_contains($title, 'sea')) {
            return 'posts/beach.jpg';
        }
        
        if (str_contains($title, 'mountain') || 
            str_contains($title, 'hiking')) {
            return 'posts/mountain.jpg';
        }
        
        // Default fallback
        return 'posts/default.jpg';
    }
    
    private function downloadUnsplashImage($post)
    {
        try {
            // Create directory if it doesn't exist
            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }
            
            // Generate a filename
            $filename = 'posts/' . str_slug($post->title) . '-' . uniqid() . '.jpg';
            
            // Get image from Unsplash based on post title
            $query = urlencode(strtolower($post->title));
            $imageUrl = "https://source.unsplash.com/random/800x600/?{$query}";
            
            // Download the image
            $imageContents = file_get_contents($imageUrl);
            
            // Save to storage
            Storage::disk('public')->put($filename, $imageContents);
            
            return $filename;
        } catch (\Exception $e) {
            // Log error but don't fail
            \Log::error("Failed to download image for post {$post->id}: " . $e->getMessage());
            return null;
        }
    }
}
