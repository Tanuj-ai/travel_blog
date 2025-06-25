<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($post->featured_image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <div class="text-sm text-gray-500 mb-4">
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->user->name }}</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                            
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800">
                                Read more →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-gray-600 text-center">No posts found.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>