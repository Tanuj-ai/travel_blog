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
}
