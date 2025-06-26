<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'destination',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the trip.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a CSS gradient class based on the destination
     * 
     * @return string
     */
    public function getDestinationGradient()
    {
        // Map of destinations to gradient classes
        $gradientMap = [
            'Bali' => 'from-green-400 to-blue-500',
            'Santorini' => 'from-blue-400 to-indigo-500',
            'Kyoto' => 'from-pink-400 to-red-500',
            'Machu Picchu' => 'from-yellow-400 to-orange-500',
            'Iceland' => 'from-blue-400 to-cyan-500',
            'Maldives' => 'from-cyan-400 to-blue-500',
            'Germany' => 'from-yellow-400 to-amber-500',
            'Paris' => 'from-blue-400 to-indigo-500',
            'Delhi' => 'from-orange-400 to-red-500',
        ];
        
        // Check if destination contains any of the keys
        foreach ($gradientMap as $key => $gradient) {
            if (stripos($this->destination, $key) !== false) {
                return $gradient;
            }
        }
        
        // Default gradient
        return 'from-gray-400 to-gray-600';
    }

    /**
     * Get an image URL for the destination
     * 
     * @return string
     */
    public function getDestinationImageUrl()
    {
        // Map of destinations to image URLs
        $imageMap = [
            'Bali' => '/images/destinations/bali.jpg',
            'Santorini' => '/images/destinations/santorini.jpg',
            'Kyoto' => '/images/destinations/kyoto.jpg',
            'Machu Picchu' => '/images/destinations/machu-picchu.jpg',
            'Iceland' => '/images/destinations/iceland.jpg',
            'Maldives' => '/images/destinations/maldives.jpg',
            'Germany' => '/images/destinations/germany.jpg',
            'Paris' => '/images/destinations/paris.jpg',
            'Delhi' => '/images/destinations/delhi.jpg',
        ];
        
        // Check if destination contains any of the keys
        foreach ($imageMap as $key => $imageUrl) {
            if (stripos($this->destination, $key) !== false) {
                return $imageUrl;
            }
        }
        
        // Default image
        return '/images/destinations/default.jpg';
    }
}



