<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        // Get published posts, ordered by published date
        $posts = Post::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->orWhere(function($query) {
                        // If user is logged in, also show their draft posts
                        if (Auth::check()) {
                            $query->where('status', 'draft')
                                  ->where('user_id', Auth::id());
                        }
                    })
                    ->with('user')  // Eager load the user relationship
                    ->paginate(9);  // Show 9 posts per page for a clean 3x3 grid
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        if ($post->status !== 'published' && Auth::id() !== $post->user_id) {
            abort(404);
        }
        
        // Check if the current user is the owner of the post
        $isOwner = Auth::check() && Auth::id() === $post->user_id;
        
        return view('posts.show', compact('post', 'isOwner'));
    }
}




