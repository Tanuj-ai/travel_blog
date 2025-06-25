<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200">
                <!-- Sidebar Header -->
                <div class="px-6 pt-8 pb-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 012-2h1.945M5.055 15H15a2 2 0 002-2v-1a2 2 0 012-2h1.945" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">The Traveller</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">Welcome, {{ Auth::user()?->name ?? 'Guest' }}</p>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 pb-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sky-50 text-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        My Posts
                    </a>
                    
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                My Trips
                            </a>
                            
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Photo Gallery
                            </a>
                            
                    
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 mt-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile Settings
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Account Settings
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Mobile Header -->
            <div class="md:hidden bg-white border-b border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <span class="ml-2 text-lg font-medium text-gray-800">The Traveller</span>
                    </div>
                    <div>
                        <button class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Sidebar (hidden by default) -->
            <div id="mobile-sidebar" class="md:hidden fixed inset-0 z-40 transform transition-transform duration-300 ease-in-out -translate-x-full">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity duration-300 ease-in-out opacity-0" id="sidebar-backdrop"></div>
                <div class="fixed inset-y-0 left-0 flex flex-col w-full max-w-xs bg-white transform transition-transform duration-300 ease-in-out -translate-x-full">
                    <!-- Mobile sidebar content (copy of desktop sidebar) -->
                    <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                        <div class="flex items-center px-4">
                            <button id="close-sidebar" class="text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <span class="ml-3 text-xl font-bold text-gray-800">TravelJournal</span>
                        </div>
                        <!-- Mobile Navigation (same as desktop) -->
                        <nav class="mt-5 px-4 space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sky-50 text-sky-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                My Posts
                            </a>
                            
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                My Trips
                            </a>
                            
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Photo Gallery
                            </a>
                            
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                                
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 mt-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile Settings
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="flex-1 overflow-auto">
                <div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <!-- Welcome Section -->
                    <div class="bg-gradient-to-r from-sky-400 to-blue-500 rounded-xl shadow-lg p-6 mb-6 text-white">
                        <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()?->name ?? 'Guest' }}!</h2>
                        <p class="mb-4">Ready to share your next adventure with the world?</p>
                        <a href="#" class="inline-block px-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                            Write New Post
                        </a>
                    </div>
                    
                    <!-- Stats Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-sky-100 text-sky-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 012-2h1.945M5.055 15H15a2 2 0 002-2v-1a2 2 0 012-2h1.945" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Published Posts</p>
                                    <p class="text-2xl font-bold">12</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Destinations Visited Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h2a2 2 0 002-2v-1a2 2 0 012-2h1.945M5.055 15H15a2 2 0 002-2v-1a2 2 0 012-2h1.945" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.945 15H15a2 2 0 01-2-2v-1a2 2 0 00-2-2h-2a2 2 0 00-2 2v1a2 2 0 01-2 2H3.055" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Destinations Visited</p>
                                    <p class="text-2xl font-bold">6</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Photos Uploaded Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Photos Uploaded</p>
                                    <p class="text-2xl font-bold">87</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Trip Days Card -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Trip Days</p>
                                    <p class="text-2xl font-bold">124</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Posts and To-Do Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Recent Posts -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-xl shadow p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Recent Posts</h3>
                                    <a href="#" class="text-sky-600 hover:text-sky-800 text-sm">View All</a>
                                </div>
                                
                                <!-- Post 1: Kyoto -->
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Kyoto" class="w-16 h-16 object-cover rounded-lg mr-4">
                                        <div>
                                            <h4 class="font-medium text-gray-900">A Week in Kyoto: Ancient Temples and Modern Delights</h4>
                                            <p class="text-sm text-gray-500">Published 3 days ago</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-3">My journey through Kyoto was a perfect blend of traditional and contemporary Japan. From the serene bamboo groves of Arashiyama to the vibrant street food scene in Nishiki Market, every moment was filled with discovery...</p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            1,245 views
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            32 comments
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Post 2: Iceland -->
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <img src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Iceland" class="w-16 h-16 object-cover rounded-lg mr-4">
                                        <div>
                                            <h4 class="font-medium text-gray-900">Chasing the Northern Lights in Iceland</h4>
                                            <p class="text-sm text-gray-500">Published 1 week ago</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-3">Standing beneath the dancing aurora borealis in Iceland was a life-changing experience. After days of exploring volcanic landscapes, relaxing in geothermal hot springs, and hiking past thundering waterfalls, the night sky put on a spectacular show that made the entire journey worthwhile...</p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            2,871 views
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            56 comments
                                        </span>
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>
                        
                        <!-- To-Do List -->
                        <div>
                            <div class="bg-white rounded-xl shadow p-6">
                                <h3 class="text-lg font-semibold mb-4">To-Do List</h3>
                                
                                <!-- Add new task form -->
                                <form id="add-task-form" class="mb-4">
                                    <div class="flex">
                                        <input type="text" id="new-task" placeholder="Add a new task..." class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
                                        <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-r-lg transition-colors">
                                            Add
                                        </button>
                                    </div>
                                </form>
                                
                                <!-- Tasks list -->
                                <div id="tasks-container" class="space-y-3">
                                    <div class="task-item flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="task-checkbox h-5 w-5 text-sky-500 rounded border-gray-300 focus:ring-sky-400">
                                            <span class="ml-3 text-gray-700">Book flight to Bali</span>
                                        </div>
                                        <button class="delete-task text-gray-400 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="task-item flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="task-checkbox h-5 w-5 text-sky-500 rounded border-gray-300 focus:ring-sky-400">
                                            <span class="ml-3 text-gray-700">Research hotels in Tokyo</span>
                                        </div>
                                        <button class="delete-task text-gray-400 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="task-item flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="task-checkbox h-5 w-5 text-sky-500 rounded border-gray-300 focus:ring-sky-400" checked>
                                            <span class="ml-3 text-gray-500 line-through">Update travel blog</span>
                                        </div>
                                        <button class="delete-task text-gray-400 hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Travel History Cards -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Your Travel History</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Bali Card -->
                            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-bali')" data-destination="destination-bali">
                                <div class="h-48 w-full relative overflow-hidden">
                                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1738&q=80" alt="Bali">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 text-white">
                                        <h3 class="text-xl font-bold">Bali, Indonesia</h3>
                                        <p class="text-sm">Visited April 2023</p>
                                    </div>
                                </div>
                                <div class="absolute bottom-3 right-3">
                                    <a href="{{ route('trips.create', ['destination' => 'Bali, Indonesia']) }}" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded transition-colors">
                                        Plan Trip
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Santorini Card -->
                            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-santorini')" data-destination="destination-santorini">
                                <div class="h-48 w-full relative overflow-hidden">
                                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" alt="Santorini">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 text-white">
                                        <h3 class="text-xl font-bold">Santorini, Greece</h3>
                                        <p class="text-sm">Visited June 2022</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kyoto Card -->
                            <div class="destination-card group rounded-xl overflow-hidden shadow-lg bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl cursor-pointer" x-data="{}" x-on:click="$dispatch('open-modal', 'destination-kyoto')" data-destination="destination-kyoto">
                                <div class="h-48 w-full relative overflow-hidden">
                                    <img class="h-full w-full object-cover transition duration-700 ease-in-out group-hover:scale-110" src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Kyoto">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 text-white">
                                        <h3 class="text-xl font-bold">Kyoto, Japan</h3>
                                        <p class="text-sm">Visited October 2022</p>
                                    </div>
                                </div>
                                <div class="absolute bottom-3 right-3">
                                    <a href="{{ route('trips.create', ['destination' => 'Kyoto, Japan']) }}" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded transition-colors">
                                        Plan Trip
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add modals at the bottom of the page -->
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
            <p class="text-gray-600 mb-4">Your trip to Bali in April 2023 was amazing! You visited beautiful beaches, rice terraces, and spiritual temples.</p>
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Highlights</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li>Ubud Sacred Monkey Forest</li>
                    <li>Tegallalang Rice Terraces</li>
                    <li>Uluwatu Temple</li>
                    <li>Seminyak Beach</li>
                </ul>
            </div>
        </div>
    </x-modal>

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
            <p class="text-gray-600 mb-4">Your trip to Santorini in June 2022 was unforgettable! You explored white-washed villages and stunning caldera views.</p>
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Highlights</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li>Oia Sunset</li>
                    <li>Fira Town</li>
                    <li>Red Beach</li>
                    <li>Akrotiri Archaeological Site</li>
                </ul>
            </div>
        </div>
    </x-modal>

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
            <p class="text-gray-600 mb-4">Your trip to Kyoto in October 2022 was a cultural journey! You visited ancient temples, traditional gardens, and experienced Japanese hospitality.</p>
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Highlights</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li>Fushimi Inari Shrine</li>
                    <li>Arashiyama Bamboo Grove</li>
                    <li>Kinkaku-ji (Golden Pavilion)</li>
                    <li>Gion District</li>
                </ul>
            </div>
        </div>
    </x-modal>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle for mobile with smooth animation
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const closeSidebar = document.getElementById('close-sidebar');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarContent = mobileSidebar?.querySelector('.flex-col');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        function openSidebar() {
            // Show the sidebar container first
            mobileSidebar.classList.remove('-translate-x-full');
            
            // Then animate the backdrop and content
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                sidebarContent.classList.remove('-translate-x-full');
            }, 10);
        }
        
        function closeSidebarWithAnimation() {
            // First animate the backdrop and content
            backdrop.classList.add('opacity-0');
            sidebarContent.classList.add('-translate-x-full');
            
            // Then hide the entire sidebar after animation completes
            setTimeout(() => {
                mobileSidebar.classList.add('-translate-x-full');
            }, 300);
        }
        
        if (sidebarToggle && mobileSidebar && closeSidebar) {
            sidebarToggle.addEventListener('click', openSidebar);
            
            closeSidebar.addEventListener('click', closeSidebarWithAnimation);
            
            // Close sidebar when clicking on backdrop
            backdrop.addEventListener('click', closeSidebarWithAnimation);
        }
        
        // Function to fetch weather data
        function fetchWeather(location, elementId) {
            const apiKey = '{{ env('OPENWEATHER_API_KEY', '5f3f2a6d2f8f4a7e9b8c7d6e5f4e3d2c') }}';
            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${location}&appid=${apiKey}&units=metric`;
            
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    const weather = data.weather[0].description;
                    const temp = Math.round(data.main.temp);
                    const feelsLike = Math.round(data.main.feels_like);
                    const humidity = data.main.humidity;
                    
                    document.getElementById(elementId).innerHTML = `
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">Current Weather</p>
                                <p class="text-sm text-gray-600 capitalize">${weather}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-800">${temp}°C</p>
                                <p class="text-xs text-gray-600">Feels like: ${feelsLike}°C</p>
                                <p class="text-xs text-gray-600">Humidity: ${humidity}%</p>
                            </div>
                        </div>
                    `;
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
                fetchWeather('Denpasar,ID', 'bali-weather');
            } else if (modalName === 'destination-santorini') {
                fetchWeather('Santorini,GR', 'santorini-weather');
            } else if (modalName === 'destination-kyoto') {
                fetchWeather('Kyoto,JP', 'kyoto-weather');
            }
        });
        
        // To-Do List Functionality
        const addTaskForm = document.getElementById('add-task-form');
        const newTaskInput = document.getElementById('new-task');
        const tasksContainer = document.getElementById('tasks-container');
        
        // Load tasks from localStorage
        function loadTasks() {
            const savedTasks = localStorage.getItem('travelTasks');
            if (savedTasks) {
                tasksContainer.innerHTML = savedTasks;
                // Re-attach event listeners to loaded tasks
                attachTaskEventListeners();
            }
        }
        
        // Save tasks to localStorage
        function saveTasks() {
            localStorage.setItem('travelTasks', tasksContainer.innerHTML);
        }
        
        // Add new task
        addTaskForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const taskText = newTaskInput.value.trim();
            if (taskText === '') return;
            
            const taskItem = document.createElement('div');
            taskItem.className = 'task-item flex items-center justify-between p-3 bg-gray-50 rounded-lg';
            taskItem.innerHTML = `
                <div class="flex items-center">
                    <input type="checkbox" class="task-checkbox h-5 w-5 text-sky-500 rounded border-gray-300 focus:ring-sky-400">
                    <span class="ml-3 text-gray-700">${taskText}</span>
                </div>
                <button class="delete-task text-gray-400 hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            
            tasksContainer.prepend(taskItem);
            newTaskInput.value = '';
            
            // Attach event listeners to the new task
            attachTaskEventListeners();
            
            // Save tasks
            saveTasks();
        });
        
        // Attach event listeners to task checkboxes and delete buttons
        function attachTaskEventListeners() {
            // Task checkbox event listeners
            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.removeEventListener('change', handleCheckboxChange);
                checkbox.addEventListener('change', handleCheckboxChange);
            });
            
            // Delete button event listeners
            document.querySelectorAll('.delete-task').forEach(button => {
                button.removeEventListener('click', handleDeleteTask);
                button.addEventListener('click', handleDeleteTask);
            });
        }
        
        // Handle checkbox change
        function handleCheckboxChange(e) {
            const taskText = e.target.nextElementSibling;
            if (e.target.checked) {
                taskText.classList.add('line-through', 'text-gray-500');
                taskText.classList.remove('text-gray-700');
            } else {
                taskText.classList.remove('line-through', 'text-gray-500');
                taskText.classList.add('text-gray-700');
            }
            saveTasks();
        }
        
        // Handle delete task
        function handleDeleteTask(e) {
            const taskItem = e.target.closest('.task-item');
            taskItem.remove();
            saveTasks();
        }
        
        // Initial load of tasks
        loadTasks();
        
        // Initial attachment of event listeners
        attachTaskEventListeners();
    });
</script>

