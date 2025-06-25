<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Destinations - Travel Blog</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
#map {
    z-index: 1 !important;
}

/* Also target Leaflet's internal elements */
.leaflet-container {
    z-index: 1 !important;
}

.leaflet-pane {
    z-index: 1 !important;
}

.leaflet-map-pane {
    z-index: 1 !important;
}
</style>

</head>
<body class="antialiased">
    <!-- Fixed Navigation Bar -->
   <nav class="fixed top-0 left-0 right-0 bg-gray-900 shadow-md z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0 flex items-center">
                            <span class="text-white font-bold text-xl">The Traveller</span>
                        </a>
                    </div>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-8">
                        <a href="/" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Home</a>
                        
                        <a href="{{ route('destinations') }}" class="text-amber-500 border-b-2 border-amber-500 px-3 py-5 text-sm font-medium">Destinations</a>
                      
                       
                        <a href="/about" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">About</a>
                        <a href="/contact" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Contact</a>
                        
                    </div>
                    
                    <!-- User Menu / Auth Buttons -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right"
                                     style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        
                                        <!-- Logout Form -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Log Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex space-x-4">
                                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Log in</a>
                                <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white focus:outline-none">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="sm:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/" class="text-amber-500 block px-3 py-2 text-base font-medium">Home</a>
                   
                    <a href="/destinations" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Destinations</a>
                    <a href="#" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Categories</a>
                    <a href="#" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Gallery</a>
                    <a href="/about" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">About</a>
                    <a href="/contact" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Contact</a>
                </div>
                
                <!-- Mobile auth menu -->
                <div class="pt-4 pb-3 border-t border-gray-700">
                    @auth
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-500 flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Profile</a>
                            
                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 px-2 space-y-1">
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Log in</a>
                            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    <!-- Hero Section -->
    <div class="relative pt-16">
        <div class="h-[60vh] relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                 alt="Scenic mountain landscape" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Explore Amazing Destinations</h1>
                    <p class="text-xl md:text-2xl mb-8">Discover the world's most breathtaking places</p>
                    <a href="{{ route('destinations') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors duration-1000 ease-in-out relative overflow-hidden group">
                        <span class="relative z-10">Browse Destinations</span>
                        <span class="absolute inset-0 bg-amber-600 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-1000 ease-in-out"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Destinations Section -->
    <div id="featured-destinations" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Featured Destinations</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    From tropical paradises to ancient wonders
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Bali Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-bali')" data-destination="destination-bali">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1738&q=80" alt="Bali">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Bali</h3>
                            <p class="text-sm text-amber-300">Indonesia</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Discover tropical beaches, lush rice terraces, and spiritual temples in this Indonesian paradise.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Bali →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Bali, Indonesia']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Santorini Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-santorini')" data-destination="destination-santorini">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" alt="Santorini">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Santorini</h3>
                            <p class="text-sm text-amber-300">Greece</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Experience the iconic white buildings, blue domes, and breathtaking sunsets of this Greek island.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Santorini →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Santorini, Greece']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Kyoto Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-kyoto')" data-destination="destination-kyoto">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Kyoto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Kyoto</h3>
                            <p class="text-sm text-amber-300">Japan</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Immerse yourself in Japanese culture with ancient temples, traditional gardens, and historic districts.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Kyoto →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'kyoto, Japan']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Machu Picchu Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-machu-picchu')" data-destination="destination-machu-picchu">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Machu Picchu">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Machu Picchu</h3>
                            <p class="text-sm text-amber-300">Peru</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Explore the ancient Incan citadel set high in the Andes Mountains, surrounded by breathtaking views.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Machu Picchu →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Machu Picchu, Peru']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Iceland Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-iceland')" data-destination="destination-iceland">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Iceland">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Iceland</h3>
                            <p class="text-sm text-amber-300">Europe</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Experience dramatic landscapes with volcanoes, geysers, hot springs, and stunning northern lights.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Iceland →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Iceland, Europe']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Maldives Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-maldives')" data-destination="destination-maldives">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Maldives">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Maldives</h3>
                            <p class="text-sm text-amber-300">South Asia</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Relax in paradise with crystal clear waters, white sandy beaches, and luxurious overwater bungalows.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Maldives →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Maldives', 'South Asia']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- Germany Card -->
                <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-germany')" data-destination="destination-germany">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Germany">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Germany</h3>
                            <p class="text-sm text-amber-300">Europe</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Discover historic cities, fairytale castles, and beautiful landscapes in the heart of Europe.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Germany →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Berlin, Germany']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- paris -->
                 <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-paris')" data-destination="destination-paris">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?&auto=format&fit=crop&w=1770&q=80" alt="Paris">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Paris</h3>
                            <p class="text-sm text-amber-300">Europe</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Discover historic cities, fairytale castles, and beautiful landscapes in the heart of Europe.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Germany →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Paris, Europe']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>

                <!-- india -->
                 <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-india')" data-destination="destination-india">
                    <div class="h-64 w-full relative overflow-hidden">
                        <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?&auto=format&fit=crop&w=1770&q=80" alt="India">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <h3 class="text-2xl font-bold text-white">Delhi</h3>
                            <p class="text-sm text-amber-300">India</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Discover historic cities, fairytale castles, and beautiful landscapes in the heart of Europe.</p>
                        <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Germany →</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('trips.create', ['destination' => 'Delhi, India']) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                            Plan Trip
                        </a>
                    </div>
                </div>
            </div>
            
          
    <!-- Map Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 uppercase tracking-wider">EXPLORE THE WORLD</h2>
                <p class="mt-2 text-lg text-gray-600">Find your next adventure on the map</p>
            </div>
            
            <div class="h-96 rounded-xl overflow-hidden shadow-lg" id="map"></div>
        </div>
    </div>
    
    <!-- Newsletter Section -->
   <!-- Newsletter Section -->
<div class="py-16 bg-amber-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-white uppercase tracking-wider">JOIN OUR NEWSLETTER</h2>
            <p class="mt-2 text-lg text-white/80">Get travel tips and exclusive destination guides delivered to your inbox</p>
            
            <form id="newsletter-form" class="mt-8 sm:flex sm:max-w-md sm:mx-auto">
                <label for="email-address" class="sr-only">Email address</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-amber-600 focus:border-transparent rounded-l-lg" placeholder="Enter your email">
                <div class="mt-3 sm:mt-0 sm:ml-3">
                    <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-r-lg text-white bg-amber-700 hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-600">
                        Subscribe
                    </button>
                </div>
            </form>
            
            <!-- Message Display Area -->
            <div id="newsletter-message" class="mt-4 hidden">
                <p class="text-white font-semibold"></p>
            </div>
        </div>
    </div>
</div>

    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">The World Travel Guy</h3>
                    <p class="text-gray-400">Exploring the world one destination at a time. Join us on our journey to discover the most beautiful places on Earth.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="/posts" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="/destinations" class="text-gray-400 hover:text-white">Destinations</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Popular Destinations</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Bali, Indonesia</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Santorini, Greece</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kyoto, Japan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Machu Picchu, Peru</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Iceland</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center">
                <p class="text-gray-400">&copy; 2023 The World Travel Guy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Destination Modals -->
    <!-- Bali Modal -->
    <x-modal name="destination-bali" :show="false" maxWidth="2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-3xl font-bold text-gray-900">Bali, Indonesia</h2>
                <button x-on:click="$dispatch('close-modal', 'destination-bali')" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="bali-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600">Loading weather data...</p>
            </div>
            <div class="mb-6">
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1738&q=80" alt="Bali" class="w-full h-64 object-cover rounded-lg">
            </div>
            <p class="text-gray-700 mb-6">Bali is an Indonesian island known for its forested volcanic mountains, iconic rice paddies, beaches and coral reefs. The island is home to religious sites such as cliffside Uluwatu Temple. To the south, the beachside city of Kuta has lively bars, while Seminyak, Sanur and Nusa Dua are popular resort towns.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                    <p class="text-gray-700">April to October (Dry Season)</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                    <p class="text-gray-700">Indonesian, Balinese</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                    <p class="text-gray-700">Indonesian Rupiah (IDR)</p>
                </div>
            </div>
            
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 mb-6 text-gray-700">
                <li>Ubud Monkey Forest</li>
                <li>Tegallalang Rice Terraces</li>
                <li>Uluwatu Temple</li>
                <li>Tanah Lot Temple</li>
                <li>Kuta Beach</li>
            </ul>
            
            <div class="flex justify-end">
                <a href="{{ route('trips.create', ['destination' => 'Bali, Indonesia']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            </div>
        </div>
    </x-modal>

    <!-- Santorini -->
<x-modal name="destination-santorini" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Santorini, Greece</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-santorini')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="santorini-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" alt="Santorini" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Santorini is a stunning Greek island in the Aegean Sea, famous for its white-washed buildings, blue-domed churches, and breathtaking sunsets over the caldera.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">April to October</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Greek</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Euro (EUR)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Oia Village</li>
            <li>Fira Town</li>
            <li>Red Beach</li>
            <li>Akrotiri Archaeological Site</li>
            <li>Caldera Views</li>
        </ul>
        <div class="flex justify-end">
            <a href="{{ route('trips.create', ['destination' => 'Santorini, Greece']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Kyoto -->
<x-modal name="destination-kyoto" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Kyoto, Japan</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-kyoto')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="kyoto-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Kyoto" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Kyoto, once the capital of Japan, is known for its classical Buddhist temples, gardens, imperial palaces, Shinto shrines, and traditional wooden houses.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">March to May, October to November</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Japanese</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Japanese Yen (JPY)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Fushimi Inari Shrine</li>
            <li>Kinkaku-ji (Golden Pavilion)</li>
            <li>Arashiyama Bamboo Grove</li>
            <li>Kiyomizu-dera Temple</li>
            <li>Gion District</li>
        </ul>
        <div class="flex justify-end">
             <a href="{{ route('trips.create', ['destination' => 'Kyoto, Japan']) }}" class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Machu Picchu -->
<x-modal name="destination-machu-picchu" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Machu Picchu, Peru</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-machu-picchu')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="machu-picchu-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Machu Picchu" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Machu Picchu is an ancient Incan citadel set high in the Andes Mountains in Peru, renowned for its sophisticated dry-stone walls and panoramic views.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">April to October</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Spanish, Quechua</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Peruvian Sol (PEN)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Sun Gate (Inti Punku)</li>
            <li>Temple of the Sun</li>
            <li>Inca Bridge</li>
            <li>Huayna Picchu</li>
            <li>Temple of the Three Windows</li>
        </ul>
       <div class="flex justify-end">
            <a href="{{ route('trips.create', ['destination' => 'Machu Picchu, Peru']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Iceland -->
<x-modal name="destination-iceland" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Iceland</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-iceland')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="iceland-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Iceland" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Iceland is a Nordic island nation defined by dramatic landscapes with volcanoes, geysers, hot springs, and lava fields, and is famous for the Northern Lights.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">June to August (Summer), February to March & September to October (Northern Lights)</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Icelandic</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Icelandic Krona (ISK)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Blue Lagoon</li>
            <li>Golden Circle</li>
            <li>Reykjavik</li>
            <li>Jökulsárlón Glacier Lagoon</li>
            <li>Seljalandsfoss Waterfall</li>
        </ul>
        <div class="flex justify-end">
            <a href="{{ route('trips.create', ['destination' => 'Iceland, Europe']) }}" class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Maldives -->
<x-modal name="destination-maldives" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Maldives</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-maldives')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="maldives-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Maldives" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">The Maldives is a tropical paradise in the Indian Ocean, known for its crystal-clear waters, white-sand beaches, and luxurious overwater bungalows.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">November to April</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Dhivehi</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Maldivian Rufiyaa (MVR)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Male City</li>
            <li>Maafushi Island</li>
            <li>Banana Reef</li>
            <li>Sun Island</li>
            <li>Veligandu Island Beach</li>
        </ul>
         <div class="flex justify-end">
             <a href="{{ route('trips.create', ['destination' => 'Maldives', 'Maldives']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Germany -->
<x-modal name="destination-germany" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Germany</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-germany')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="germany-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Germany" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Germany is a country in Central Europe known for its rich history, fairy-tale castles, vibrant cities, and scenic landscapes from the Black Forest to the Bavarian Alps.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">May to September</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">German</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Euro (EUR)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Brandenburg Gate</li>
            <li>Neuschwanstein Castle</li>
            <li>Berlin Wall</li>
            <li>Black Forest</li>
            <li>Cologne Cathedral</li>
        </ul>
         <div class="flex justify-end">
             <a href="{{ route('trips.create', ['destination' => 'Germany, Europe']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Paris -->
<x-modal name="destination-paris" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">Paris, France</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-paris')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="paris-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?&auto=format&fit=crop&w=1770&q=80" alt="Paris" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">Paris, the capital of France, is famed for its art, fashion, gastronomy, and culture. Its 19th-century cityscape is crisscrossed by wide boulevards and the River Seine.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">April to June, September to November</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">French</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Euro (EUR)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Eiffel Tower</li>
            <li>Louvre Museum</li>
            <li>Notre-Dame Cathedral</li>
            <li>Montmartre</li>
            <li>Champs-Élysées</li>
        </ul>
        <div class="flex justify-end">
                 <a href="{{ route('trips.create', ['destination' => 'Paris, Europe']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- India -->
<x-modal name="destination-india" :show="false" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-gray-900">India</h2>
            <button x-on:click="$dispatch('close-modal', 'destination-india')" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="india-weather" class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600">Loading weather data...</p>
        </div>
        <div class="mb-6">
            <img src="https://images.unsplash.com/photo-1454023492550-5696f8ff10e1?&auto=format&fit=crop&w=1770&q=80" alt="India" class="w-full h-64 object-cover rounded-lg">
        </div>
        <p class="text-gray-700 mb-6">India is a vast and diverse country in South Asia, celebrated for its rich culture, history, cuisine, and landmarks like the Taj Mahal, palaces, temples, and natural wonders.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">October to March</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Language</h3>
                <p class="text-gray-700">Hindi, English, and 20+ regional languages</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Currency</h3>
                <p class="text-gray-700">Indian Rupee (INR)</p>
            </div>
        </div>
        <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
        <ul class="list-disc pl-5 mb-6 text-gray-700">
            <li>Taj Mahal</li>
            <li>Jaipur (Pink City)</li>
            <li>Kerala Backwaters</li>
            <li>Varanasi Ghats</li>
            <li>Goa Beaches</li>
        </ul>
        <div class="flex justify-end">
 <a href="{{ route('trips.create', ['destination' => 'Delhi, India']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>


    <!-- JavaScript for Map -->
    <script>
        // Enhanced version with better styling
const newsletterForm = document.getElementById('newsletter-form');
const newsletterMessage = document.getElementById('newsletter-message');

if (newsletterForm && newsletterMessage) {
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const emailInput = document.getElementById('email-address');
        const email = emailInput.value.trim();
        const submitButton = newsletterForm.querySelector('button[type="submit"]');
        
        if (email) {
            // Temporarily disable button and show loading
            submitButton.textContent = 'Subscribing...';
            submitButton.disabled = true;
            
            // Simulate API call delay
            setTimeout(function() {
                // Show success message
                newsletterMessage.querySelector('p').innerHTML = '🎉 <strong>Successfully Subscribed!</strong><br>Thank you for joining our newsletter!';
                newsletterMessage.classList.remove('hidden');
                
                // Clear input and reset button
                emailInput.value = '';
                submitButton.textContent = 'Subscribe';
                submitButton.disabled = false;
                
                // Hide message after 4 seconds
                setTimeout(function() {
                    newsletterMessage.classList.add('hidden');
                }, 4000);
            }, 1000);
        } else {
            // Show error message
            newsletterMessage.querySelector('p').innerHTML = '❌ <strong>Please enter a valid email address</strong>';
            newsletterMessage.classList.remove('hidden');
            
            setTimeout(function() {
                newsletterMessage.classList.add('hidden');
            }, 3000);
        }
    });
}

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Leaflet map
            const map = L.map('map').setView([20, 0], 2);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Add markers for featured destinations
            const destinations = [
                { name: 'Bali', coords: [-8.4095, 115.1889], modal: 'destination-bali' },
                { name: 'Santorini', coords: [36.3932, 25.4615], modal: 'destination-santorini' },
                { name: 'Kyoto', coords: [35.0116, 135.7681], modal: 'destination-kyoto' },
                { name: 'Machu Picchu', coords: [-13.1631, -72.5450], modal: 'destination-machu-picchu' },
                { name: 'Iceland', coords: [64.9631, -19.0208], modal: 'destination-iceland' },
                { name: 'Maldives', coords: [3.2028, 73.2207], modal: 'destination-maldives' },
                { name: 'Germany', coords: [51.1657, 10.4515], modal: 'destination-germany' },
                { name: 'India', coords: [20.5937, 78.9629], modal: 'destination-india' },
                { name: 'Paris', coords: [48.8566, 2.3522], modal: 'destination-paris' }

            ];
            
            destinations.forEach(dest => {
                const marker = L.marker(dest.coords).addTo(map);
                marker.bindPopup(`<b>${dest.name}</b><br><a href="#" class="text-blue-500" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: '${dest.modal}' })); return false;">View details</a>`);
            });
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Weather API functionality
            function fetchWeather(location, elementId) {
                const apiKey = 'c3350498e2eed1f3fbb8c30f9c704a30';
                const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${location}&appid=${apiKey}&units=metric`;
                
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.cod === 200) {
                            const temp = Math.round(data.main.temp);
                            const description = data.weather[0].description;
                            const icon = data.weather[0].icon;
                            const humidity = data.main.humidity;
                            const windSpeed = data.wind.speed;
                            
                            document.getElementById(elementId).innerHTML = `
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Current Weather</h3>
                                        <p class="text-gray-600">${description}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${description}" class="w-16 h-16">
                                        <span class="text-3xl font-bold text-gray-800">${temp}°C</span>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-2 text-sm text-gray-600">
                                    <span>Humidity: ${humidity}%</span>
                                    <span>Wind: ${windSpeed} m/s</span>
                                </div>
                            `;
                        } else {
                            document.getElementById(elementId).innerHTML = '<p class="text-gray-600">Weather data unavailable</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather:', error);
                        document.getElementById(elementId).innerHTML = '<p class="text-gray-600">Failed to load weather data</p>';
                    });
            }
            
            // Load weather data when modals are opened
            window.addEventListener('open-modal', function(event) {
                const modalName = event.detail;
                
                  if (modalName === 'destination-bali') {
        fetchWeather('Denpasar,ID', 'bali-weather');
    } else if (modalName === 'destination-santorini') {
        fetchWeather('Santorini,GR', 'santorini-weather');
    } else if (modalName === 'destination-kyoto') {
        fetchWeather('Kyoto,JP', 'kyoto-weather');
    } else if (modalName === 'destination-machu-picchu') {
        fetchWeather('Cusco,PE', 'machu-picchu-weather');
    } else if (modalName === 'destination-iceland') {
        fetchWeather('Reykjavik,IS', 'iceland-weather');
    } else if (modalName === 'destination-maldives') {
        fetchWeather('Male,MV', 'maldives-weather');
    } else if (modalName === 'destination-germany') {
        fetchWeather('Berlin,DE', 'germany-weather');
    } else if (modalName === 'destination-paris') {
        fetchWeather('Paris,FR', 'paris-weather');
    } else if (modalName === 'destination-india') {
        fetchWeather('Delhi,IN', 'india-weather');
    }
            });
        });
    </script>
</body>
</html>








