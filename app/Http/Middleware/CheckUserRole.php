public function handle($request, Closure $next)
{
    $user = Auth::user();
    
    if (!$user) {
        return redirect('/login');
    }
    
    // Now it's safe to access $user->name
    
    return $next($request);
}