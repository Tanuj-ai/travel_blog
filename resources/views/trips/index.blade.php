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
            @if(count($trips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($trips as $trip)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $trip->name }}</h3>
                                        <p class="text-gray-600">{{ $trip->destination }}</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - 
                                            {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $trip->travelers }} {{ Str::plural('traveler', $trip->travelers) }}
                                            @if($trip->budget)
                                                • Budget: ${{ number_format($trip->budget, 2) }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $trip->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $trip->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                    <a href="{{ route('trips.show', ['trip' => $trip->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </a>
                                    <a href="{{ route('trips.edit', ['trip' => $trip->id]) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Edit Trip
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No trips planned yet</h3>
                        <p class="text-gray-600 mb-6">Start planning your next adventure by creating a new trip.</p>
                        <a href="{{ route('trips.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Plan Your First Trip
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
