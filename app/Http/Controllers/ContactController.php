<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        // If you're passing user data to the view, add null checks
        $user = Auth::user();
        $userName = $user ? $user->name : '';
        $userEmail = $user ? $user->email : '';
        
        return view('contact', [
            'userName' => $userName,
            'userEmail' => $userEmail,
        ]);
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}



