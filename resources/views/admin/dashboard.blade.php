<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome to the Admin Dashboard</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- User Management Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">User Management</h3>
                                <p class="text-gray-600 mb-4">Manage user accounts and permissions.</p>
                                <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800">Manage Users →</a>
                            </div>
                        </div>
                        
                        <!-- Post Management Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Content Management</h3>
                                <p class="text-gray-600 mb-4">Manage blog posts and content.</p>
                                <a href="{{ route('admin.posts') }}" class="text-blue-600 hover:text-blue-800">Manage Posts →</a>
                            </div>
                        </div>
                        
                        <!-- Destination Management Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Destination Management</h3>
                                <p class="text-gray-600 mb-4">Manage travel destinations and details.</p>
                                <a href="{{ route('admin.destinations') }}" class="text-blue-600 hover:text-blue-800">Manage Destinations →</a>
                            </div>
                        </div>
                    </div>
                    
                    @if(isset($latestUsers) && $latestUsers->count() > 0)
                        <div class="mt-8">
                            <h4 class="font-medium mb-3">Latest Registered Users</h4>
                            <div class="bg-white rounded-lg border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($latestUsers as $user)
                                        <li class="px-4 py-3">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:underline">View all users →</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




