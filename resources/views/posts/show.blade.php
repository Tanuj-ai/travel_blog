<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($post->featured_image)
                    <div class="h-80 overflow-hidden">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                @endif
                
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                    
                    <div class="flex items-center text-gray-500 mb-8">
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <span>By {{ $post->user->name }}</span>
                    </div>
                    
                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>
                    
                    <div class="mt-12 pt-6 border-t border-gray-200">
                        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                            ← Back to all posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>