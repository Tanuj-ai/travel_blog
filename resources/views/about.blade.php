<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - The Traveller</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            filter: brightness(0.4);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 0 2rem;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-content {
            position: relative;
            z-index: 5;
            margin-top: -100px;
            padding: 0 2rem 4rem;
        }

        .content-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .story-section {
            background: white;
            border-radius: 24px;
            padding: 4rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .story-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #718096;
            max-width: 600px;
            margin: 0 auto;
        }

        .story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 4rem;
        }

        .story-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #4a5568;
        }

        .story-text p {
            margin-bottom: 1.5rem;
        }

        .highlight {
            color: #667eea;
            font-weight: 600;
        }

        .story-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transform: rotate(-2deg);
            transition: transform 0.3s ease;
        }

        .story-image:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .story-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .team-section {
            background: white;
            border-radius: 24px;
            padding: 4rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .team-member {
            text-align: center;
            padding: 2rem;
            border-radius: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transition: transform 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
        }

        .member-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: #667eea;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .member-bio {
            color: #718096;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .story-section {
                padding: 2rem;
            }
            
            .story-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .team-section {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
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
                <a href="/" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Home</a>
                <a href="/destinations" class="text-gray-300 hover:text-white block px-3 py-2 text-base font-medium">Destinations</a>
                <a href="/about" class="text-amber-500 block px-3 py-2 text-base font-medium">About</a>
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Our Story</h1>
            <p class="hero-subtitle">Passionate Travelers • Digital Nomads • Adventure Seekers</p>
            <p class="hero-description">
                Welcome to our world of wanderlust, where every journey tells a story and every destination becomes a cherished memory.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-container">
            <!-- Our Story Section -->
            <div class="story-section">
                <div class="section-header">
                    <h2 class="section-title">Who We Are</h2>
                    <p class="section-subtitle">
                        Meet the passionate travelers behind The Traveller - your guides to extraordinary adventures around the globe.
                    </p>
                </div>

                <div class="story-grid">
                    <div class="story-text">
                        <p>
                            Hi there! We're <span class="highlight">Alex & Sarah Martinez</span>, a husband and wife team who traded our corporate careers for a life of adventure and exploration. What started as a two-week honeymoon in Southeast Asia turned into a <span class="highlight">life-changing journey</span> that has taken us to over 75 countries across 6 continents.
                        </p>
                        <p>
                            Our mission is simple: to inspire and empower fellow travelers to explore the world with confidence, curiosity, and respect for local cultures. Through detailed guides, honest reviews, and practical tips, we help you create your own unforgettable adventures.
                        </p>
                        <p>
                            From <span class="highlight">budget backpacking</span> through remote villages to <span class="highlight">luxury escapes</span> in world-class destinations, we've experienced it all and we're here to share every lesson learned along the way.
                        </p>
                    </div>
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Travel couple exploring mountains">
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-number" data-count="75">0</div>
                        <div class="stat-label">Countries Explored</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="500">0</div>
                        <div class="stat-label">Miles Traveled</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="1">0</div>
                        <div class="stat-label">Photos Captured</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="50">0</div>
                        <div class="stat-label">Happy Readers</div>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            
        </div>
    </div>

    <!-- Mobile menu JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Stats counter animation
            const statElements = document.querySelectorAll('.stat-number');
            const animationDuration = 2000; // 2 seconds
            
            // Function to check if element is in viewport
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
            
            // Function to animate counting
            function animateCounter(element) {
                const target = parseInt(element.getAttribute('data-count'));
                const suffix = target >= 500 ? 'K+' : '+';
                const increment = target / (animationDuration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        clearInterval(timer);
                        current = target;
                    }
                    element.textContent = Math.floor(current) + suffix;
                }, 16);
            }
            
            // Start animation when scrolled into view
            function checkScroll() {
                statElements.forEach(element => {
                    if (isInViewport(element) && !element.classList.contains('animated')) {
                        element.classList.add('animated');
                        animateCounter(element);
                    }
                });
            }
            
            // Check on scroll and initial load
            window.addEventListener('scroll', checkScroll);
            checkScroll();
        });
    </script>
</body>
</html>


