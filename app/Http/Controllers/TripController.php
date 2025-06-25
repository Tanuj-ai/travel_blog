<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TripController extends Controller
{
    public function index()
    {
        $trips = Auth::user()->trips()->latest()->get();
        return view('trips.index', compact('trips'));
    }

    public function create(Request $request)
    {
        // Get the destination from the query parameter if it exists
        $destination = $request->query('destination');
        
        return view('trips.create', compact('destination'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'destination' => 'required|string|max:255',
            'travelers' => 'required|integer|min:1',
            'budget' => 'nullable|numeric',
        ]);

        $trip = Auth::user()->trips()->create($validated);
        
        return redirect()->route('trips.edit', $trip)
            ->with('success', 'Trip created successfully! Now you can plan your itinerary.');
    }

    /**
     * Display the specified trip.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        // Ensure the user can only view their own trips
        $this->authorize('view', $trip);
        
        // Log for debugging
        \Log::info('Viewing trip details:', ['trip_id' => $trip->id, 'user_id' => auth()->id()]);
        
        return view('trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $this->authorize('update', $trip);
        return view('trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $this->authorize('update', $trip);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'destination' => 'sometimes|required|string|max:255',
            'travelers' => 'sometimes|required|integer|min:1',
            'budget' => 'nullable|numeric',
            'itinerary' => 'nullable|array',
            'accommodations' => 'nullable|array',
            'transportation' => 'nullable|array',
            'expenses' => 'nullable|array',
            'packing_list' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_public' => 'sometimes|boolean',
        ]);
        
        // Handle checkbox for is_public
        if (!$request->has('is_public')) {
            $validated['is_public'] = false;
        }
        
        $trip->update($validated);
        
        return redirect()->route('trips.edit', $trip)->with('status', 'Trip details updated successfully!');
    }

    public function destroy(Trip $trip)
    {
        $this->authorize('delete', $trip);
        
        $trip->delete();
        
        return redirect()->route('trips.index')
            ->with('success', 'Trip deleted successfully!');
    }

    /**
     * Get weather forecast for a destination.
     */
    private function getWeatherForecast($destination)
    {
        try {
            // Use the API key from config or use a fallback
            $apiKey = config('services.openweather.key', 'c3350498e2eed1f3fbb8c30f9c704a30');
            
            // Make the API request
            $response = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
                'q' => $destination,
                'appid' => $apiKey,
                'units' => 'metric',
                'cnt' => 5 // Get forecast for 5 days
            ]);
            
            // Log the response for debugging
            \Log::info('Weather API response for ' . $destination, [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            \Log::error('Weather API error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            \Log::error('Weather API exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get weather forecast for a destination (API endpoint).
     */
    public function getWeather($destination)
    {
        $weather = $this->getWeatherForecast($destination);
        
        if (!$weather) {
            return response()->json(['error' => 'Weather data not available'], 404);
        }
        
        return response()->json($weather);
    }

    public function updatePackingList(Request $request, Trip $trip)
    {
        $this->authorize('update', $trip);
        
        $validated = $request->validate([
            'packing_list' => 'required|array',
            'packing_list.*.name' => 'required|string',
            'packing_list.*.packed' => 'required|boolean',
        ]);
        
        $trip->update([
            'packing_list' => $validated['packing_list']
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Packing list updated successfully',
            'packing_list' => $trip->packing_list
        ]);
    }

    /**
     * Update the expenses for the specified trip.
     */
    public function updateExpenses(Request $request, Trip $trip)
    {
        $this->authorize('update', $trip);
        
        $validated = $request->validate([
            'expenses' => 'required|array',
            'expenses.*.description' => 'required|string',
            'expenses.*.category' => 'required|string',
            'expenses.*.amount' => 'required|numeric|min:0',
        ]);
        
        $trip->update([
            'expenses' => $validated['expenses']
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Expenses updated successfully',
            'expenses' => $trip->expenses
        ]);
    }

    /**
     * Save all trip details at once.
     */
    public function saveAll(Request $request, Trip $trip)
    {
        try {
            $this->authorize('update', $trip);
            
            // Log the incoming request for debugging
            \Log::info('Trip save-all request:', $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'destination' => 'required|string|max:255',
                'travelers' => 'required|integer|min:1',
                'budget' => 'nullable|numeric',
                'itinerary' => 'nullable|array',
                'accommodations' => 'nullable|array',
                'transportation' => 'nullable|array',
                'expenses' => 'nullable|array',
                'packing_list' => 'nullable|array',
                'notes' => 'nullable|string',
                'is_public' => 'boolean',
            ]);
            
            $trip->update($validated);
            
            // Generate URL for thank you page
            $redirectUrl = route('trips.thank-you', ['trip' => $trip->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'All trip details saved successfully',
                'redirect_url' => $redirectUrl
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving trip details: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving trip details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display thank you page after saving trip.
     */
    public function thankYou(Trip $trip)
    {
        $this->authorize('view', $trip);
        
        return view('trips.thank-you', compact('trip'));
    }
}











