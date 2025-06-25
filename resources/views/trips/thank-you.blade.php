<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trip Saved') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-green-500 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Thank You!</h3>
                    <p class="text-lg text-gray-600 mb-6">Your trip to {{ $trip->destination }} has been saved successfully.</p>
                    
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Return to Dashboard
                        </a>
                        <a href="{{ route('trips.edit', $trip) }}" class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Continue Editing
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>