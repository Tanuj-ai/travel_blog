<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Get user count
        $userCount = User::count();
        
        // Get latest users
        $latestUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'latestUsers' => $latestUsers
        ]);
    }
    
    /**
     * Show the admin test page.
     */
    public function test()
    {
        return view('admin.test');
    }
    
    /**
     * Show the users management page.
     */
    public function users(Request $request)
    {
        // Initialize search variable with null or the search input
        $search = $request->input('search', null);
        
        $query = User::query();
        
        // Only filter if search is not null or empty
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        
        // Always pass search to the view, even if it's null
        return view('admin.users', [
            'users' => $users,
            'search' => $search
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Prevent deletion of admin user
        if ($user->email === 'sidharththakur@gmail.com') {
            return redirect()->route('admin.users')->with('error', 'Cannot delete admin user');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    /**
     * Display a listing of the posts for admin.
     */
    public function posts(Request $request)
    {
        $query = Post::query()->with('user');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }
        
        // Filter by status
        if ($request->has('status') && $request->get('status') !== 'all') {
            $query->where('status', $request->get('status'));
        }
        
        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function createPost()
    {
        return view('admin.create-post');
    }

    /**
     * Store a newly created post in storage.
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);
        
        $slug = Str::slug($validated['title']);
        $uniqueSlug = $slug;
        $counter = 1;
        
        // Ensure slug is unique
        while (Post::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter++;
        }
        
        $post = new Post([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $uniqueSlug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = $path;
        }
        
        $post->save();
        
        return redirect()->route('admin.posts')->with('success', 'Post created successfully');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function editPost(Post $post)
    {
        return view('admin.edit-post', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function updatePost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);
        
        $post->title = $validated['title'];
        $post->excerpt = $validated['excerpt'] ?? null;
        $post->content = $validated['content'];
        
        // Update published_at if status changes to published
        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $post->published_at = now();
        }
        
        $post->status = $validated['status'];
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = $path;
        }
        
        $post->save();
        
        return redirect()->route('admin.posts')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroyPost(Post $post)
    {
        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();
        
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully');
    }

    /**
     * Display the destinations management page.
     */
    public function destinations()
    {
        return view('admin.destinations');
    }
}




