<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetupBlogImages extends Command
{
    protected $signature = 'blog:setup-images';
    protected $description = 'Setup image folder structure and default images for the blog';

    // Categories of images we'll create
    protected $categories = [
        'travel', 'nature', 'city', 'food', 'people'
    ];

    public function handle()
    {
        $this->info('Setting up blog image folders...');

        // Create main images directory in public folder if it doesn't exist
        if (!File::exists(public_path('images'))) {
            File::makeDirectory(public_path('images'), 0755, true);
            $this->info('Created main images directory');
        }

        // Create blog images directory
        if (!File::exists(public_path('images/blog'))) {
            File::makeDirectory(public_path('images/blog'), 0755, true);
            $this->info('Created blog images directory');
        }

        // Create category subdirectories
        foreach ($this->categories as $category) {
            if (!File::exists(public_path("images/blog/{$category}"))) {
                File::makeDirectory(public_path("images/blog/{$category}"), 0755, true);
                $this->info("Created {$category} category directory");
            }
        }

        // Create placeholder images for each category
        foreach ($this->categories as $category) {
            $this->createCategoryPlaceholders($category);
        }

        // Create special images
        $this->createSpecialImages();

        // Create symbolic link to storage if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        $this->info('Blog image setup completed successfully!');
        return Command::SUCCESS;
    }

    private function createCategoryPlaceholders($category)
    {
        $dir = public_path("images/blog/{$category}");
        
        // Create 3 placeholder images for each category
        for ($i = 1; $i <= 3; $i++) {
            $filename = "{$dir}/{$category}-{$i}.jpg";
            
            if (!File::exists($filename)) {
                $this->info("Creating {$category} image {$i}...");
                
                // Different colors for different categories
                switch ($category) {
                    case 'travel':
                        $bgColor = [52, 152, 219]; // Blue
                        break;
                    case 'nature':
                        $bgColor = [46, 204, 113]; // Green
                        break;
                    case 'city':
                        $bgColor = [155, 89, 182]; // Purple
                        break;
                    case 'food':
                        $bgColor = [231, 76, 60]; // Red
                        break;
                    case 'people':
                        $bgColor = [241, 196, 15]; // Yellow
                        break;
                    default:
                        $bgColor = [189, 195, 199]; // Gray
                }
                
                $this->createPlaceholderImage(
                    $filename,
                    ucfirst($category) . " Image {$i}",
                    $bgColor,
                    [255, 255, 255]
                );
            }
        }
    }

    private function createSpecialImages()
    {
        // Create Northern Lights image
        if (!File::exists(public_path('images/blog/northern-lights.jpg'))) {
            $this->info('Creating Northern Lights image...');
            $this->createPlaceholderImage(
                public_path('images/blog/northern-lights.jpg'),
                'Northern Lights',
                [0, 32, 64], // Dark blue background
                [173, 216, 230] // Light blue text
            );
        }
        
        // Create Beach Sunset image
        if (!File::exists(public_path('images/blog/beach-sunset.jpg'))) {
            $this->info('Creating Beach Sunset image...');
            $this->createPlaceholderImage(
                public_path('images/blog/beach-sunset.jpg'),
                'Beach Sunset',
                [230, 126, 34], // Orange background
                [255, 255, 255] // White text
            );
        }
        
        // Create Mountain View image
        if (!File::exists(public_path('images/blog/mountain-view.jpg'))) {
            $this->info('Creating Mountain View image...');
            $this->createPlaceholderImage(
                public_path('images/blog/mountain-view.jpg'),
                'Mountain View',
                [46, 134, 193], // Blue background
                [255, 255, 255] // White text
            );
        }
        
        // Create default post image
        if (!File::exists(public_path('images/default-post.jpg'))) {
            $this->info('Creating default post image...');
            $this->createPlaceholderImage(
                public_path('images/default-post.jpg'),
                'Blog Post',
                [52, 73, 94], // Dark blue-gray
                [255, 255, 255] // White text
            );
        }
        
        // Create default featured image
        if (!File::exists(public_path('images/default-featured.jpg'))) {
            $this->info('Creating default featured image...');
            $this->createPlaceholderImage(
                public_path('images/default-featured.jpg'),
                'Featured Post',
                [44, 62, 80], // Very dark blue-gray
                [255, 255, 255] // White text
            );
        }
    }

    private function createPlaceholderImage($path, $text, $bgColorArray = [240, 240, 240], $textColorArray = [100, 100, 100])
    {
        // Create a simple image with text
        $image = imagecreatetruecolor(800, 600);
        $bgColor = imagecolorallocate($image, $bgColorArray[0], $bgColorArray[1], $bgColorArray[2]);
        $textColor = imagecolorallocate($image, $textColorArray[0], $textColorArray[1], $textColorArray[2]);
        
        imagefill($image, 0, 0, $bgColor);
        
        // Add text
        $font = 5; // Built-in font
        
        // Center the text
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        $centerX = (800 - $textWidth) / 2;
        $centerY = (600 - $textHeight) / 2;
        
        imagestring($image, $font, $centerX, $centerY, $text, $textColor);
        
        // Save the image
        imagejpeg($image, $path, 90);
        imagedestroy($image);
    }
}