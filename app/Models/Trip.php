<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'destination',
        'travelers',
        'budget',
        'itinerary',
        'accommodations',
        'transportation',
        'expenses',
        'packing_list',
        'notes',
        'is_public',
        'collaborators'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'itinerary' => 'array',
        'accommodations' => 'array',
        'transportation' => 'array',
        'expenses' => 'array',
        'packing_list' => 'array',
        'collaborators' => 'array',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a destination image URL for the trip
     */
    public function getDestinationImageUrl($width = 800, $height = 400)
    {
        // Clean the destination name for better image search
        $cleanDestination = $this->getCleanDestinationName();

        // Use multiple image services with better reliability
        $imageServices = [
            // Unsplash with better search terms
            "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w={$width}&h={$height}&fit=crop&crop=center&auto=format&q=80",
            // Picsum as fallback
            "https://picsum.photos/{$width}/{$height}?random=" . abs(crc32($this->destination)),
            // Lorem Picsum with seed
            "https://picsum.photos/seed/" . md5($this->destination) . "/{$width}/{$height}",
        ];

        // For now, let's use a more reliable approach with predefined beautiful images
        $destinationImages = $this->getDestinationSpecificImage($width, $height);

        return $destinationImages ?: $imageServices[1]; // Return destination-specific or fallback
    }

    /**
     * Get destination-specific images from the destinations page
     */
    private function getDestinationSpecificImage($width = 800, $height = 400)
    {
        $destination = strtolower($this->destination);

        // Exact images from the destinations page - matching destination names
        $destinationImages = [
            // Specific destinations from destinations page
            'bali' => "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'santorini' => "https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'kyoto' => "https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'machu picchu' => "https://images.unsplash.com/photo-1526392060635-9d6019884377?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'iceland' => "https://images.unsplash.com/photo-1504893524553-b855bce32c67?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'maldives' => "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'germany' => "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'paris' => "https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'india' => "https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'delhi' => "https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?w={$width}&h={$height}&fit=crop&auto=format&q=80",

            // Additional common destinations
            'tokyo' => "https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Kyoto image for Japan
            'japan' => "https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'greece' => "https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Santorini for Greece
            'peru' => "https://images.unsplash.com/photo-1526392060635-9d6019884377?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Machu Picchu for Peru
            'indonesia' => "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Bali for Indonesia
            'france' => "https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Paris for France
            'europe' => "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Use Germany for Europe

            // Category-based images (fallback)
            'beach' => "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Maldives
            'island' => "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Maldives
            'mountain' => "https://images.unsplash.com/photo-1526392060635-9d6019884377?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Machu Picchu
            'city' => "https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Paris
            'alps' => "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Germany
            'swiss' => "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w={$width}&h={$height}&fit=crop&auto=format&q=80", // Germany
            'new york' => "https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'london' => "https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w={$width}&h={$height}&fit=crop&auto=format&q=80",
            'rome' => "https://images.unsplash.com/photo-1552832230-c0197dd311b5?w={$width}&h={$height}&fit=crop&auto=format&q=80",

            // Default travel image
            'default' => "https://images.unsplash.com/photo-1488646953014-85cb44e25828?w={$width}&h={$height}&fit=crop&auto=format&q=80",
        ];

        // First, try exact destination name match
        foreach ($destinationImages as $destName => $imageUrl) {
            if ($destName !== 'default' && str_contains($destination, $destName)) {
                return $imageUrl;
            }
        }

        // Return default travel image
        return $destinationImages['default'];
    }

    /**
     * Clean destination name for better image search
     */
    private function getCleanDestinationName()
    {
        // Remove common words and clean the destination name
        $destination = $this->destination;

        // Remove country codes and common separators
        $destination = preg_replace('/,\s*[A-Z]{2,3}$/', '', $destination); // Remove country codes like ", US"
        $destination = preg_replace('/,.*$/', '', $destination); // Remove everything after first comma

        // Get the main city/location name
        $parts = explode(',', $destination);
        $mainLocation = trim($parts[0]);

        return $mainLocation;
    }

    /**
     * Get fallback gradient colors based on destination
     */
    public function getDestinationGradient()
    {
        $gradients = [
            'default' => 'from-blue-500 via-purple-500 to-pink-500',
            'beach' => 'from-cyan-400 via-blue-500 to-blue-600',
            'mountain' => 'from-green-400 via-green-600 to-green-800',
            'city' => 'from-gray-400 via-gray-600 to-gray-800',
            'desert' => 'from-yellow-400 via-orange-500 to-red-500',
            'forest' => 'from-green-300 via-green-500 to-green-700',
        ];

        $destination = strtolower($this->destination);

        if (str_contains($destination, 'beach') || str_contains($destination, 'island') || str_contains($destination, 'coast')) {
            return $gradients['beach'];
        } elseif (str_contains($destination, 'mountain') || str_contains($destination, 'hill') || str_contains($destination, 'peak')) {
            return $gradients['mountain'];
        } elseif (str_contains($destination, 'city') || str_contains($destination, 'urban')) {
            return $gradients['city'];
        } elseif (str_contains($destination, 'desert') || str_contains($destination, 'sand')) {
            return $gradients['desert'];
        } elseif (str_contains($destination, 'forest') || str_contains($destination, 'jungle') || str_contains($destination, 'woods')) {
            return $gradients['forest'];
        }

        return $gradients['default'];
    }
}
