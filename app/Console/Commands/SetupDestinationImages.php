<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupDestinationImages extends Command
{
    protected $signature = 'setup:destination-images';
    protected $description = 'Set up default destination images';

    public function handle()
    {
        $this->info('Setting up destination images...');
        
        // Create destination images directory if it doesn't exist
        $destinationDir = public_path('images/destinations');
        if (!File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }
        
        // Create a default placeholder image if it doesn't exist
        $defaultImagePath = $destinationDir . '/default.jpg';
        if (!File::exists($defaultImagePath)) {
            // Create a simple placeholder image
            $image = imagecreatetruecolor(800, 600);
            $bgColor = imagecolorallocate($image, 200, 200, 200);
            $textColor = imagecolorallocate($image, 50, 50, 50);
            
            imagefill($image, 0, 0, $bgColor);
            imagestring($image, 5, 300, 280, 'Destination Image', $textColor);
            
            imagejpeg($image, $defaultImagePath);
            imagedestroy($image);
            
            $this->info('Created default destination image');
        }
        
        $this->info('Destination images setup complete');
        
        return Command::SUCCESS;
    }
}