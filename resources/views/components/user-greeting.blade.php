<div>
    Hello, {{ Auth::user()?->name ?? 'Guest' }}!
</div>

