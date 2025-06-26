<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogImageController extends Controller
{
    /**
     * Display a listing of available blog images
     */
    public function index()
    {
        // Only allow in admin area
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403);
        }
        
        $images = $this->getAllBlogImages();
        
        return view('admin.blog-images', [
            'images' => $images
        ]);
    }
    
    /**
     * Assign an image to a post
     */
    public function assignToPost(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'image_path' => 'required|string'
        ]);
        
        // Check if image exists
        $fullPath = public_path($validated['image_path']);
        if (!File::exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Image does not exist'
            ], 404);
        }
        
        // Update post with new image
        DB::table('posts')
            ->where('id', $validated['post_id'])
            ->update(['featured_image' => $validated['image_path']]);
        
        return response()->json([
            'success' => true,
            'message' => 'Image assigned to post successfully'
        ]);
    }
    
    /**
     * Get a random image for a post based on its title/content
     */
    public function getRandomImageForPost($postId)
    {
        $post = DB::table('posts')->find($postId);
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
        
        // Determine best category based on post title/content
        $category = $this->determineBestCategory($post);
        
        // Get random image from that category
        $imagePath = $this->getRandomImageFromCategory($category);
        
        // Update post with new image
        DB::table('posts')
            ->where('id', $post->id)
            ->update(['featured_image' => $imagePath]);
        
        return response()->json([
            'success' => true,
            'message' => 'Random image assigned to post',
            'image_path' => $imagePath
        ]);
    }
    
    /**
     * Fix all posts with missing images
     */
    public function fixAllPostImages()
    {
        // Only allow in local/development environment
        if (!app()->environment(['local', 'development'])) {
            return response()->json([
                'success' => false,
                'message' => 'This action is only available in development environments'
            ], 403);
        }
        
        $posts = DB::table('posts')->get();
        $fixed = 0;
        $details = [];
        
        foreach ($posts as $post) {
            // If post has no image or image doesn't exist
            if (!$post->featured_image || !File::exists(public_path($post->featured_image))) {
                // Determine best category based on post title/content
                $category = $this->determineBestCategory($post);
                
                // Get random image from that category
                $imagePath = $this->getRandomImageFromCategory($category);
                
                // Update post with new image
                DB::table('posts')
                    ->where('id', $post->id)
                    ->update(['featured_image' => $imagePath]);
                
                $fixed++;
                $details[] = "Fixed post ID {$post->id}: {$post->title} with image {$imagePath}";
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Fixed {$fixed} posts with missing images",
            'details' => $details
        ]);
    }
    
    /**
     * Get all blog images
     */
    private function getAllBlogImages()
    {
        $images = [];
        $basePath = public_path('images/blog');
        
        if (!File::exists($basePath)) {
            return $images;
        }
        
        // Get all categories (directories)
        $categories = File::directories($basePath);
        
        // Add special images in the blog root
        $specialImages = File::files($basePath);
        foreach ($specialImages as $image) {
            if (in_array(strtolower($image->getExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = [
                    'path' => 'images/blog/' . $image->getFilename(),
                    'name' => $image->getFilename(),
                    'category' => 'special'
                ];
            }
        }
        
        // Add images from each category
        foreach ($categories as $categoryPath) {
            $categoryName = basename($categoryPath);
            $categoryImages = File::files($categoryPath);
            
            foreach ($categoryImages as $image) {
                if (in_array(strtolower($image->getExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $images[] = [
                        'path' => 'images/blog/' . $categoryName . '/' . $image->getFilename(),
                        'name' => $image->getFilename(),
                        'category' => $categoryName
                    ];
                }
            }
        }
        
        return $images;
    }
    
    /**
     * Determine best category based on post title/content
     */
    private function determineBestCategory($post)
    {
        $title = strtolower($post->title);
        $content = strtolower($post->content ?? '');
        
        // Check for specific keywords
        if (Str::contains($title, ['northern lights', 'aurora', 'iceland']) || 
            Str::contains($content, ['northern lights', 'aurora', 'iceland'])) {
            return 'special/northern-lights';
        }
        
        if (Str::contains($title, ['beach', 'ocean', 'sea', 'coast', 'shore']) || 
            Str::contains($content, ['beach', 'ocean', 'sea', 'coast', 'shore'])) {
            return 'nature';
        }
        
        if (Str::contains($title, ['mountain', 'hiking', 'trek', 'hill', 'climb']) || 
            Str::contains($content, ['mountain', 'hiking', 'trek', 'hill', 'climb'])) {
            return 'nature';
        }
        
        if (Str::contains($title, ['food', 'restaurant', 'cuisine', 'dish', 'meal']) || 
            Str::contains($content, ['food', 'restaurant', 'cuisine', 'dish', 'meal'])) {
            return 'food';
        }
        
        if (Str::contains($title, ['city', 'urban', 'downtown', 'metropolis']) || 
            Str::contains($content, ['city', 'urban', 'downtown', 'metropolis'])) {
            return 'city';
        }
        
        if (Str::contains($title, ['people', 'person', 'portrait', 'face']) || 
            Str::contains($content, ['people', 'person', 'portrait', 'face'])) {
            return 'people';
        }
        
        // Default to travel category
        return 'travel';
    }
    
    /**
     * Get random image from category
     */
    private function getRandomImageFromCategory($category)
    {
        // Handle special cases
        if ($category === 'special/northern-lights') {
            return 'images/blog/northern-lights.jpg';
        }
        
        $basePath = public_path('images/blog/' . $category);
        
        // If category doesn't exist, use default
        if (!File::exists($basePath)) {
            return 'images/default-post.jpg';
        }
        
        // Get all images in the category
        $images = File::files($basePath);
        $validImages = [];
        
        foreach ($images as $image) {
            if (in_array(strtolower($image->getExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
                $validImages[] = 'images/blog/' . $category . '/' . $image->getFilename();
            }
        }
        
        // If no valid images, use default
        if (empty($validImages)) {
            return 'images/default-post.jpg';
        }
        
        // Return random image
        return $validImages[array_rand($validImages)];
    }
    
    /**
     * Remove all images from blog posts
     */
    public function removeAllImages()
    {
        // Only allow in admin area
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403);
        }
        
        // Get all posts
        $posts = DB::table('posts')->get();
        $count = 0;
        
        foreach ($posts as $post) {
            if ($post->featured_image) {
                // Update post to remove image
                DB::table('posts')
                    ->where('id', $post->id)
                    ->update(['featured_image' => null]);
                
                $count++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Removed images from {$count} posts"
        ]);
    }
}
