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
        if ($user->email === 'yamansharmarakta@gmail.com') {
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
        
        // Only show posts for the current user unless they're an admin
        // Check if user is admin by email (temporary solution)
        $isAdmin = Auth::user()->email === 'yamansharmarakta@gmail.com';
        if (!$isAdmin) {
            $query->where('user_id', Auth::id());
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
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
            'hashtags' => 'nullable|string|max:255',
        ]);
        
        $slug = Str::slug($validated['title']);
        $uniqueSlug = $slug;
        $counter = 1;
        
        // Ensure slug is unique
        while (Post::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter++;
        }
        
        // Create the post with the current user's ID
        $post = new Post([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $uniqueSlug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'hashtags' => $validated['hashtags'] ?? null,
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = $path;
        }
        
        $post->save();
        
        // Debug information
        \Log::info('Post created', [
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'title' => $post->title
        ]);
        
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
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_path' => 'nullable|string',
            'status' => 'required|in:draft,published'
        ]);
        
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->excerpt = $validated['excerpt'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $post->status = $validated['status'];
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = $path;
        } 
        // Handle image path from blog images
        elseif ($request->filled('image_path')) {
            $post->featured_image = $validated['image_path'];
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













