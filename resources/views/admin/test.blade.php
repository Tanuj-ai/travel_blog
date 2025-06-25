<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Test Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">This is a test page for admin functionality</h3>
                    <p>If you can see this, you have admin access.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">
                            ← Back to Admin Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>