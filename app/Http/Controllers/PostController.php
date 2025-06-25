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
        $posts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
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
        
        return view('posts.show', compact('post'));
    }
}

