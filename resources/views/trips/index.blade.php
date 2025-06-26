<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Trips') }}
            </h2>
            <a href="{{ route('trips.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('Plan New Trip') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(count($trips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    @foreach($trips as $trip)
                        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                            <!-- Card Header with Destination Image -->
                            <div class="relative h-32 overflow-hidden bg-gradient-to-br {{ $trip->getDestinationGradient() }}">
                                <!-- Background Image -->
                                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                                     style="background-image: url('{{ $trip->getDestinationImageUrl() }}');">
                                </div>
                                <!-- Gradient Overlay for better text readability -->
                                <div class="absolute inset-0 bg-gradient-to-br from-black/50 via-black/30 to-black/60"></div>

                                <div class="relative z-10 flex justify-between items-start h-full p-6">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-white mb-2 line-clamp-2 leading-tight drop-shadow-lg">{{ $trip->name }}</h3>
                                        <div class="flex items-center text-white/95">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0 drop-shadow" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium truncate drop-shadow">{{ $trip->destination }}</span>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $trip->is_public ? 'bg-green-400/90 text-green-900 backdrop-blur-sm' : 'bg-white/20 text-white backdrop-blur-sm' }} border border-white/30 drop-shadow">
                                        {{ $trip->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="relative z-10 p-6">
                                <!-- Trip Details -->
                                <div class="space-y-4 mb-6">
                                    <!-- Dates -->
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">
                                            {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} -
                                            {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <!-- Travelers and Budget -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ $trip->travelers }} {{ Str::plural('traveler', $trip->travelers) }}</span>
                                        </div>
                                        @if($trip->budget)
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                <span class="text-sm font-semibold text-gray-700">${{ number_format($trip->budget, 0) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="relative z-20 flex items-center justify-between pt-4 border-t border-gray-100">
                                    <a href="{{ route('trips.show', ['trip' => $trip->id]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200 cursor-pointer">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('trips.edit', ['trip' => $trip->id]) }}" class="inline-flex items-center p-2 text-green-600 bg-green-50 rounded-lg hover:bg-green-100 hover:text-green-700 transition-colors duration-200 cursor-pointer" title="Edit Trip">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('trips.destroy', $trip) }}" class="inline relative z-30" onsubmit="return confirmDelete('{{ $trip->name }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors duration-200 cursor-pointer" title="Delete Trip">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="relative bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-3xl shadow-xl overflow-hidden">
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm"></div>
                    <div class="relative p-12 text-center">
                        <!-- Animated Icon -->
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full w-24 h-24 mx-auto opacity-20 animate-pulse"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-500 mx-auto relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <h3 class="text-3xl font-bold text-gray-800 mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Ready for Adventure?
                        </h3>
                        <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                            Your journey begins with a single step. Start planning your next unforgettable adventure today.
                        </p>

                        <a href="{{ route('trips.create') }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Plan Your First Trip
                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }

        .bg-clip-text {
            -webkit-background-clip: text;
            background-clip: text;
        }

        /* Enhanced drop shadow for better text readability */
        .drop-shadow-lg {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
        }

        .drop-shadow {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        /* Image loading animation */
        .bg-cover {
            transition: opacity 0.3s ease-in-out;
        }

        /* Fallback for when images don't load */
        .destination-bg {
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>

    <script>
        function confirmDelete(tripName) {
            console.log('Delete confirmation for:', tripName);
            return confirm(`Are you sure you want to delete the trip "${tripName}"? This action cannot be undone.`);
        }

        // Add click event listeners
        document.addEventListener('DOMContentLoaded', function() {

            // Debug edit buttons
            document.querySelectorAll('a[href*="trips"][href*="edit"]').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    console.log('Edit button clicked:', this.href);
                });
            });

            // Debug delete buttons
            document.querySelectorAll('button[type="submit"]').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    console.log('Delete button clicked');
                });
            });

            // Debug view buttons
            document.querySelectorAll('a[href*="trips"][href*="show"]').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    console.log('View button clicked:', this.href);
                });
            });
        });
    </script>
</x-app-layout>
