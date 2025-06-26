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
                        <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <span>By {{ $post->user->name }}</span>
                        
                        @if(isset($isOwner) && $isOwner)
                            <span class="mx-2">•</span>
                            <span class="text-blue-600">Your post</span>
                        @endif
                    </div>
                    
                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>
                    
                    @if($post->hashtags)
                        <div class="mt-6">
                            @foreach(explode(',', $post->hashtags) as $tag)
                                <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-semibold text-gray-600 mr-2 mb-2">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="mt-12 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                                ← Back to all posts
                            </a>
                            
                            @if(isset($isOwner) && $isOwner)
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        Edit Post
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                            Delete Post
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
