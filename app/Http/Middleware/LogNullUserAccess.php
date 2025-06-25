<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogNullUserAccess
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() === false) {
            Log::warning('Accessing route without authenticated user', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip()
            ]);
        }
        
        return $next($request);
    }
}