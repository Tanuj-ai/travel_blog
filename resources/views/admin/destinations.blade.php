<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Destinations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Destinations Management</h3>
                    <p>This feature is coming soon.</p>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>