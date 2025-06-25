<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $trip->name }}
            </h2>
            <a href="{{ route('trips.edit', $trip) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('Edit Trip') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Trip Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $trip->destination }}</h3>
                            <p class="text-gray-600">
                                {{ $trip->travelers }} {{ Str::plural('traveler', $trip->travelers) }}
                            </p>
                            @if($trip->budget)
                                <p class="text-gray-600">Budget: ${{ number_format($trip->budget, 2) }}</p>
                            @endif
                            <p class="text-gray-600 mt-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full {{ $trip->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $trip->is_public ? 'Public' : 'Private' }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="bg-blue-50 px-4 py-2 rounded-lg">
                                <p class="text-sm text-gray-500">Departure</p>
                                <p class="text-lg font-medium text-blue-800">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="bg-green-50 px-4 py-2 rounded-lg mt-2">
                                <p class="text-sm text-gray-500">Return</p>
                                <p class="text-lg font-medium text-green-800">
                                    {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add other sections like Itinerary, Accommodations, etc. -->
            
            <div class="flex justify-between">
                <a href="{{ route('trips.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                    {{ __('Back to Trips') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>


