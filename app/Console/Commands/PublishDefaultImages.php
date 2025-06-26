<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishDefaultImages extends Command
{
    protected $signature = 'images:publish';
    protected $description = 'Publish default images for the blog';

    public function handle()
    {
        // Create the images directory if it doesn't exist
        if (!File::exists(public_path('images'))) {
            File::makeDirectory(public_path('images'), 0755, true);
        }

        // Create a simple default image for posts if it doesn't exist
        if (!File::exists(public_path('images/default-post.jpg'))) {
            $this->info('Creating default post image placeholder...');
            $this->createPlaceholderImage(public_path('images/default-post.jpg'), 'Post');
        }

        // Create a simple default image for featured posts if it doesn't exist
        if (!File::exists(public_path('images/default-featured.jpg'))) {
            $this->info('Creating default featured image placeholder...');
            $this->createPlaceholderImage(public_path('images/default-featured.jpg'), 'Featured');
        }
        
        // Create a specific Northern Lights image
        if (!File::exists(public_path('images/northern-lights.jpg'))) {
            $this->info('Creating Northern Lights image placeholder...');
            $this->createPlaceholderImage(
                public_path('images/northern-lights.jpg'), 
                'Northern Lights', 
                [0, 32, 64], // Dark blue background
                [173, 216, 230] // Light blue text
            );
        }

        $this->info('Default images published successfully!');
        return Command::SUCCESS;
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
        $text = "Default $text Image";
        
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
