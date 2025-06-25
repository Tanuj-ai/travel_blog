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
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            color: #222;
        }
        .hero-section {
            position: relative;
            width: 100%;
            height: 380px;
            background: url('/images/about-hero.jpg') center center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.25);
        }
        .hero-content {
            position: relative;
            text-align: center;
            color: #fff;
            z-index: 2;
        }
        .hero-title {
            font-size: 2.7em;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 0.3em;
        }
        .hero-subtitle {
            font-size: 1.25em;
            font-weight: 300;
        }
        .torn-divider {
            width: 100%;
            height: 54vh;
        }
        .about-container {
            max-width: 950px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 18px rgba(0,0,0,0.06);
            padding: 40px 28px 28px 28px;
            margin-bottom: 40px;
        }
        .section-title {
            color: #ff6600;
            font-size: 1.1em;
            letter-spacing: 1px;
            font-weight: bold;
            margin-bottom: 0.3em;
        }
        .about-name {
            font-size: 2em;
            font-weight: 600;
            margin-bottom: 0.5em;
        }
        .about-description {
            font-size: 1.18em;
            line-height: 1.7;
            margin-bottom: 2em;
        }
        .about-images {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
            margin-bottom: 1.5em;
        }
        .about-img {
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            object-fit: cover;
        }
        @media (max-width: 900px) {
            .about-container { padding: 20px 8px; }
            .about-images { flex-direction: column; align-items: center; }
            .about-img { width: 90vw; max-width: 350px; }
        }
    </style>
</head>
<body>
    <!-- navbar -->
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
                <a href="/" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Home</a>
               
                <a href="{{ route('destinations') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Destinations</a>
                <a href="/about" class="text-amber-500 border-b-2 border-amber-500 px-3 py-5 text-sm font-medium">About</a>
                <a href="/contact" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Contact</a>
            </div>
            <!-- User Menu / Auth Buttons -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right bg-white ring-1 ring-black ring-opacity-5 py-1" style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
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

<!-- Mobile menu JS (add before </body> or in your app.js if using Alpine/Livewire) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>




    <!-- and of the navbar -->
    <div class="hero-section">
        <div class="hero-overlay">

            <img src="{{ url('videos/world.jpg') }}" alt="" class="torn-divider">
        </div>
        <div class="hero-content">
            <div class="hero-title">ABOUT</div>
            
        </div>
    </div>

    <div class="about-container">
        <div class="section-title">ABOUT ME</div>
        <div class="about-name">Me</div>
        <div class="about-description">
            Hi! I’m a passionate traveler and storyteller. My journey began with a love for exploring new cultures, hidden gems, and breathtaking landscapes. Alongside my wife, I’ve visited over 60 countries, capturing our adventures and sharing tips to inspire others to see the world.<br><br>
            From hiking remote trails in Asia to discovering ancient ruins in Europe, we believe travel is about meaningful experiences and unforgettable memories. This blog is our way of helping you plan your own epic journeys, avoid travel pitfalls, and discover places you’ll never forget.
        </div>
        <div class="about-images">
            <img src="{{ url('videos/camel.jpg') }}" alt="Travel photo 1" class="about-img">
            <img src="{{ url('videos/map.webp') }}" alt="Travel photo 2" class="about-img">
        </div>
        <div class="about-description">
            Thank you for visiting our blog! We hope our stories and guides help you on your adventures.<br><br>
            
        </div>
    </div>
</body>
</html>
