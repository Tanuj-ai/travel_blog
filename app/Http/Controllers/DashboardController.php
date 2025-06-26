<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Trip;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get the user's trips
        $trips = $user->trips()->latest()->take(6)->get();
        
        // Get the user's posts
        $posts = $user->posts()->latest()->take(5)->get();
        
        // Log for debugging
        \Log::info('Dashboard data', [
            'user_id' => $user->id,
            'posts_count' => $posts->count(),
            'trips_count' => $trips->count(),
            'posts' => $posts->pluck('title', 'id')->toArray()
        ]);
        
        return view('dashboard', compact('trips', 'posts'));
    }
}

