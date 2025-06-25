<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Error') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-red-600 mb-4">{{ $message ?? 'An error occurred' }}</h3>
                    
                    @if(config('app.debug') && isset($details))
                        <div class="bg-gray-100 p-4 rounded mt-4">
                            <p class="font-mono text-sm">{{ $details }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Return to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>