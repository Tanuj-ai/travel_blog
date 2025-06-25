public function index()
{
    $trips = Auth::user()->trips()->latest()->take(6)->get();
    return view('dashboard', compact('trips'));
}

