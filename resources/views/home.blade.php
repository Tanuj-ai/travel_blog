<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">    <head>
        <meta charset="utf-8">        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Travel Blog - Explore the World</title>        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">        <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Add this in the head section of your document -->
        <script>
            // Weather API functionality
            document.addEventListener('DOMContentLoaded', function() {
                // OpenWeatherMap API key - replace with your actual API key
                const apiKey = 'c3350498e2eed1f3fbb8c30f9c704a30';
                
                // Function to fetch weather data
                function fetchWeather(city, elementId) {
                    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}`;
                    
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.cod === 200) {
                                const weatherElement = document.getElementById(elementId);
                                if (weatherElement) {
                                    const temp = Math.round(data.main.temp);
                                    const description = data.weather[0].description;
                                    const icon = data.weather[0].icon;
                                    const humidity = data.main.humidity;
                                    const windSpeed = data.wind.speed;
                                    
                                    weatherElement.innerHTML = `
                                        <div class="flex items-center mb-2">
                                            <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${description}" class="w-16 h-16">
                                            <div class="ml-2">
                                                <div class="text-2xl font-bold">${temp}°C</div>
                                                <div class="capitalize">${description}</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="font-semibold">Humidity:</span> ${humidity}%
                                            </div>
                                            <div>
                                                <span class="font-semibold">Wind:</span> ${windSpeed} m/s
                                            </div>
                                        </div>
                                    `;
                                }
                            } else {
                                console.error('Weather data not available');
                                document.getElementById(elementId).innerHTML = '<p>Weather data not available</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching weather:', error);
                            document.getElementById(elementId).innerHTML = '<p>Failed to load weather data</p>';
                        });
                }
                
                // Load weather data when modals are opened
                window.addEventListener('open-modal', function(event) {
                    const modalName = event.detail;
                    
                    if (modalName === 'destination-bali') {
                        fetchWeather('Denpasar,ID', 'bali-weather'); // Using Denpasar (Bali's capital)
                    } else if (modalName === 'destination-santorini') {
                        fetchWeather('Santorini,GR', 'santorini-weather');
                    } else if (modalName === 'destination-kyoto') {
                        fetchWeather('Kyoto,JP', 'kyoto-weather');
                    } else if (modalName === 'destination-machu-picchu') {
                        fetchWeather('Cusco,PE', 'machu-picchu-weather'); // Using Cusco as Machu Picchu is not a city
                    } else if (modalName === 'destination-iceland') {
                        fetchWeather('Reykjavik,IS', 'iceland-weather');
                    } else if (modalName === 'destination-germany') {
                        fetchWeather('Berlin,DE', 'germany-weather');
                    }
                });
            });
        </script>
    </head>    <body class="antialiased bg-white font-sans">
        <!-- Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 bg-gray-900 shadow-md z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0 flex items-center">
                            <span class="text-white font-bold text-xl">The Traveller</span>
                        </a>
                    </div>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-8">
                        <a href="/" class="text-amber-500 border-b-2 border-amber-500 px-3 py-5 text-sm font-medium">Home</a>
                        <a href="{{ route('destinations') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Destinations</a>
                        <a href="{{ route('about') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">About</a>
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
        <div class="relative bg-gray-50" style="height: 100vh;">
            <div class="absolute inset-0 h-3/4">
                <div class="hero-video relative w-full" style="height: 100vh;">
                    <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
                        <source src="{{ asset('videos/hero-background.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <img class="absolute inset-0 w-full h-full object-cover" src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Travel destination" style="display: none;">
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-gray-900/70 to-gray-900/30" style="height: 100vh;"></div>
            </div>
            <div class="relative max-w-5xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 text-center" style="top : 100px;">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">EXPLORE. DREAM. DISCOVER.</h1>
                <p class="mt-6 text-2xl text-white max-w-3xl mx-auto">Discover Amazing Wonders of India.</p>
                <div class="mt-10 flex justify-center space-x-4">
                    <a href="{{ route('destinations') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors duration-1000 ease-in-out relative overflow-hidden group">
                        <span class="relative z-10">Explore Destinations</span>
                        <span class="absolute inset-0 bg-amber-600 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-1000 ease-in-out"></span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Featured Destinations Grid -->
        <!-- Featured Destinations Grid -->
<div id="destinations" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Popular Destinations</h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                Discover breathtaking places and plan your next adventure
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Bali Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer bali" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-bali')" data-destination="destination-bali">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1738&q=80" alt="Bali">
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
            </div>

            <!-- Santorini Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer santorini" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-santorini')" data-destination="destination-santorini">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" alt="Santorini">
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
            </div>

            <!-- Kyoto Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer kyoto" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-kyoto')" data-destination="destination-kyoto">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Kyoto">
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
            </div>

            <!-- Machu Picchu Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer machu-picchu" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-machu-picchu')" data-destination="destination-machu-picchu">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Machu Picchu">
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
            </div>

            <!-- Iceland Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer iceland" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-iceland')" data-destination="destination-iceland">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80" alt="Iceland">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-2xl font-bold text-white">Iceland</h3>
                        <p class="text-sm text-amber-300">Europe</p>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Witness dramatic landscapes with volcanoes, geysers, hot springs, lava fields, and massive glaciers.</p>
                    <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Iceland →</span>
                </div>
            </div>

            <!-- Germany Card -->
            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer germany" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-germany')" data-destination="destination-germany">
                <div class="h-64 w-full relative overflow-hidden">
                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Germany">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-70 group-hover:opacity-90 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-2xl font-bold text-white">Germany</h3>
                        <p class="text-sm text-amber-300">Europe</p>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Discover fairytale castles, historic cities, and beautiful countryside in the heart of Europe.</p>
                    <span class="inline-block text-amber-600 font-medium hover:text-amber-500">Explore Germany →</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View All Destinations Button -->
<div class="mt-2 mb-12 text-center">
    <a href="{{ route('destinations') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors relative overflow-hidden group">
        <span class="relative z-10">View All Destinations</span>
        <span class="absolute inset-0 bg-amber-600 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300 ease-in-out"></span>
    </a>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">TravelBlog</h3>
                <p class="text-gray-300">Discover the world with us. We provide the best travel experiences and guides for your next adventure.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="#destinations" class="text-gray-300 hover:text-white transition-colors">Destinations</a></li>
                  
                    <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="#about" class="text-gray-300 hover:text-white transition-colors">About</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Popular Destinations</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Bali</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Santorini</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Kyoto</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Iceland</a></li>
                </ul>
            </div>
            <div id="contact">
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        info@travelblog.com
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        +1 (123) 456-7890
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        123 Travel Street, City, Country
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="text-gray-400 hover:text-white">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
            </div>
            <p>&copy; 2023 TravelBlog. All rights reserved.</p>
        </div>
    </div>
</footer>
<!-- Add these modals at the bottom of your page, before the closing body tag -->

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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1738&q=80" alt="Bali">
        </div>
        
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
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="bali-weather" class="bg-amber-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Bali</h3>
            <p class="text-gray-700 mb-4">
                Bali is an Indonesian island known for its forested volcanic mountains, iconic rice paddies, beaches and coral reefs. 
                The island is home to religious sites such as cliffside Uluwatu Temple. To the south, the beachside city of Kuta has lively bars, 
                while Seminyak, Sanur and Nusa Dua are popular resort towns.
            </p>
            <p class="text-gray-700">
                The island is also known for its yoga and meditation retreats, as well as its traditional arts and crafts.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>Ubud Monkey Forest and Art Market</li>
                <li>Sacred Monkey Forest Sanctuary</li>
                <li>Tegallalang Rice Terraces</li>
                <li>Uluwatu Temple</li>
                <li>Tanah Lot Temple</li>
            </ul>
        </div>
        
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

<!-- Santorini Modal -->
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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" alt="Santorini">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">April to October</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Language</h3>
                <p class="text-gray-700">Greek</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Currency</h3>
                <p class="text-gray-700">Euro (EUR)</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="santorini-weather" class="bg-blue-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Santorini</h3>
            <p class="text-gray-700 mb-4">
                Santorini is one of the Cyclades islands in the Aegean Sea. It was devastated by a volcanic eruption in the 16th century BC, 
                forever shaping its rugged landscape. The whitewashed, cubiform houses of its two principal towns, Fira and Oia, cling to cliffs 
                above an underwater caldera (crater).
            </p>
            <p class="text-gray-700">
                They overlook the sea, small islands to the west and beaches made up of black, red and white lava pebbles.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>Oia Sunset Views</li>
                <li>Fira Town</li>
                <li>Akrotiri Archaeological Site</li>
                <li>Red Beach</li>
                <li>Santo Wines Winery</li>
            </ul>
        </div>
        
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

<!-- Kyoto Modal -->
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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Kyoto">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">March-May and October-November</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Language</h3>
                <p class="text-gray-700">Japanese</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Currency</h3>
                <p class="text-gray-700">Japanese Yen (JPY)</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="kyoto-weather" class="bg-green-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Kyoto</h3>
            <p class="text-gray-700 mb-4">
                Kyoto, once the capital of Japan, is a city on the island of Honshu. It's famous for its numerous classical Buddhist temples, gardens, imperial palaces, Shinto shrines and traditional wooden houses. It's also known for formal traditions such as kaiseki dining, consisting of multiple courses of precise dishes, and geisha, female entertainers often found in the Gion district.
            </p>
            <p class="text-gray-700">
                With its 2,000 religious places – 1,600 Buddhist temples and 400 Shinto shrines, as well as palaces, gardens and architecture intact – it is one of the best preserved cities in Japan and has been awarded UNESCO World Heritage status.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>Fushimi Inari Shrine</li>
                <li>Kinkaku-ji (Golden Pavilion)</li>
                <li>Arashiyama Bamboo Grove</li>
                <li>Kiyomizu-dera Temple</li>
                <li>Gion District</li>
                <li>Philosopher's Path</li>
                <li>Nijo Castle</li>
            </ul>
        </div>
        
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

<!-- Machu Picchu Modal -->
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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Machu Picchu">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-amber-50 p-4 rounded-lg">
                <h3 class="font-semibold text-amber-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">May to September (Dry Season)</p>
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
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="machu-picchu-weather" class="bg-amber-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Machu Picchu</h3>
            <p class="text-gray-700 mb-4">
                Machu Picchu is an ancient Incan citadel set high in the Andes Mountains in Peru, above the Urubamba River valley. Built in the 15th century and later abandoned, it's renowned for its sophisticated dry-stone walls that fuse huge blocks without the use of mortar.
            </p>
            <p class="text-gray-700">
                Its exact former use remains a mystery. Often referred to as the "Lost City of the Incas," it was declared a UNESCO World Heritage Site in 1983 and was named one of the New Seven Wonders of the World in 2007.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>The Sun Gate (Inti Punku)</li>
                <li>Huayna Picchu</li>
                <li>Temple of the Sun</li>
                <li>Intihuatana Stone</li>
                <li>Sacred District</li>
                <li>Agricultural Terraces</li>
            </ul>
        </div>
        
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

<!-- Iceland Modal -->
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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80" alt="Iceland">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">June to September</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Language</h3>
                <p class="text-gray-700">Icelandic</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Currency</h3>
                <p class="text-gray-700">Icelandic Króna (ISK)</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="iceland-weather" class="bg-blue-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Iceland</h3>
            <p class="text-gray-700 mb-4">
                Iceland is a Nordic island country in the North Atlantic Ocean, with a population of 360,000. It's known for its dramatic landscapes, including volcanoes, geysers, hot springs, lava fields, and massive glaciers.
            </p>
            <p class="text-gray-700">
                The country is composed of 17.8% of the total land area of Europe and is the 18th largest country in Europe by area, the 102nd largest
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80" alt="Iceland">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">June to August (Summer), September to March (Northern Lights)</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Language</h3>
                <p class="text-gray-700">Icelandic</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Currency</h3>
                <p class="text-gray-700">Icelandic Króna (ISK)</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="iceland-weather" class="bg-blue-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Iceland</h3>
            <p class="text-gray-700 mb-4">
                Iceland is a Nordic island country in the North Atlantic Ocean, with a population of 360,000. It's known for its dramatic landscapes, including volcanoes, geysers, hot springs, and glaciers.
            </p>
            <p class="text-gray-700">
                The country is home to the Northern Lights, which can be seen in the winter months, and it's a popular destination for hiking, skiing, and whale watching.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>Blue Lagoon</li>
                <li>Geysir Geothermal Area</li>
                <li>Gullfoss Waterfall</li>
                <li>Thingvellir National Park</li>
                <li>Reykjavik City</li>
                <li>Snæfellsjökull Glacier</li>
            </ul>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('trips.create', ['destination' => 'Reykjavik, Iceland']) }}" class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

<!-- Germany Modal -->
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
        
        <div class="relative h-80 mb-6 rounded-lg overflow-hidden">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Germany">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Best Time to Visit</h3>
                <p class="text-gray-700">May to September</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Language</h3>
                <p class="text-gray-700">German</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800 mb-2">Currency</h3>
                <p class="text-gray-700">Euro (EUR)</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Current Weather</h3>
            <div id="germany-weather" class="bg-green-50 p-4 rounded-lg">
                <div class="animate-pulse flex space-x-4">
                    <div class="rounded-full bg-slate-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-slate-200 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">About Germany</h3>
            <p class="text-gray-700 mb-4">
                Germany is a Western European country with a landscape of forests, rivers, mountain ranges and North Sea beaches. It has over 2 millennia of history. Berlin, its capital, is home to art and nightlife scenes, the Brandenburg Gate and many sites relating to WWII.
            </p>
            <p class="text-gray-700">
                Germany is known for its rich cultural history, world-class museums, beautiful castles, delicious cuisine, and famous Oktoberfest beer festival. The country offers diverse experiences from the urban sophistication of cities like Munich and Berlin to the fairy-tale landscapes of Bavaria.
            </p>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Top Attractions</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li>Neuschwanstein Castle</li>
                <li>Brandenburg Gate</li>
                <li>The Berlin Wall</li>
                <li>Cologne Cathedral</li>
                <li>The Black Forest</li>
                <li>Romantic Road</li>
            </ul>
        </div>
        
        <div class="flex justify-end">
             <a href="{{ route('trips.create', ['destination' => 'Germany', 'Europe']) }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                Plan Your Trip
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</x-modal>

</body>
<script>
    document.addEventListener('alpine:init', () => {
        console.log('Alpine.js initialized');
    });
    
    // Improved fallback for direct click handling
    document.querySelectorAll('.destination-card').forEach(card => {
        card.addEventListener('click', function() {
            const destination = this.getAttribute('data-destination');
            
            if (destination) {
                // Try both methods to ensure compatibility
                window.dispatchEvent(new CustomEvent('open-modal', { detail: destination }));
                
                // Alternative approach for Alpine.js
                const event = new CustomEvent('open-modal', { detail: destination });
                window.dispatchEvent(event);
                
                console.log('Clicked on:', destination);
            }
        });
    });
    
    // Additional handler for modal opening
    window.addEventListener('open-modal', (event) => {
        console.log('Modal event triggered:', event.detail);
    });
</script>
</html>










































