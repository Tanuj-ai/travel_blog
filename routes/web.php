<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AboutController; // <-- Add this line

// Home route
Route::get('/', function () {
    return view('home');
});

// Destinations route
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations');

// Dashboard route
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// About page route
Route::get('/about', [AboutController::class, 'index'])->name('about');

require __DIR__.'/auth.php';

// Public post routes
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Posts management
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/create', [AdminController::class, 'createPost'])->name('posts.create');
    Route::post('/posts', [AdminController::class, 'storePost'])->name('posts.store');
    Route::get('/posts/{post}/edit', [AdminController::class, 'editPost'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

// Test route without middleware for debugging
Route::get('/admin-test', [AdminController::class, 'index'])->name('admin.test.public');

// Fallback route for admin area
Route::get('/admin/{any}', function () {
    if (Auth::check() && Auth::user()->email === 'yamansharmarakta@gmail.com') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin area.');
})->where('any', '.*')->middleware('auth');

// Simple admin route without middleware for testing
Route::get('/admin-direct', function () {
    if (Auth::check() && Auth::user()->email === 'yamansharmarakta@gmail.com') {
        return view('admin.dashboard');
    }
    return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin area.');
})->middleware('auth')->name('admin.direct');

// Test database connection
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection successful. Connected to: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});

// Trip Planning Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('trips', TripController::class);
    Route::post('trips/{trip}/share', [TripController::class, 'share'])->name('trips.share');
    Route::post('trips/{trip}/export', [TripController::class, 'export'])->name('trips.export');
    Route::get('trips/{trip}/thank-you', [TripController::class, 'thankYou'])->name('trips.thank-you');
    
    // API routes for trip planning features
    Route::prefix('api')->middleware(['auth'])->group(function () {
        Route::post('trips/{trip}/itinerary', [TripController::class, 'updateItinerary']);
        Route::post('trips/{trip}/expenses', [TripController::class, 'updateExpenses']);
        Route::post('trips/{trip}/packing-list', [TripController::class, 'updatePackingList']);
        Route::get('weather/{destination}', [TripController::class, 'getWeather']);
    });
});

// Add this route for saving all trip details
Route::post('trips/{trip}/save-all', [App\Http\Controllers\TripController::class, 'saveAll'])
    ->name('trips.saveAll')
    ->middleware(['auth']);

// Add this route for the thank you page
Route::get('trips/{trip}/thank-you', [App\Http\Controllers\TripController::class, 'thankYou'])
    ->name('trips.thank-you')
    ->middleware(['auth']);

// Make sure this route is defined correctly
Route::get('trips/{trip}', [App\Http\Controllers\TripController::class, 'show'])
    ->name('trips.show')
    ->middleware(['auth']);



