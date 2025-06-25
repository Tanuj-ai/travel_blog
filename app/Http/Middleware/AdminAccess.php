<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access the admin area.');
        }
        
        // Check if user has the specific admin email
        if (Auth::user()->email !== 'yamansharmarakta@gmail.com') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin area. Admin access is restricted to yamansharmarakta@gmail.com');
        }
        
        return $next($request);
    }
}

