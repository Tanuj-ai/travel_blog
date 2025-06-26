<x-app-layout>
    <!-- Clean, modern hero section -->
    <section class="relative bg-blue-700 py-20">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('images/travel-bg.jpg') }}" alt="Travel background" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Travel Blog</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Discover travel stories, tips, and inspiration from around the world.</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(isset($posts) && count($posts) > 0)
            <!-- Featured post - clean, modern design -->
            <div class="mb-16">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="md:flex">
                        <div class="md:w-1/2">
                            <div class="h-64 md:h-full overflow-hidden bg-gray-200">
                                @if($posts[0]->featured_image)
                                    <img 
                                        src="{{ asset('storage/' . $posts[0]->featured_image) }}" 
                                        alt="{{ $posts[0]->title }}" 
                                        class="post-image w-full h-full object-cover"
                                        data-type="featured"
                                        data-post-id="{{ $posts[0]->id }}"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="text-gray-400 text-center p-4">
                                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p>No image</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                            <div class="flex items-center mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                                <span class="mx-2 text-gray-300">•</span>
                                <span class="text-sm text-gray-500">{{ $posts[0]->published_at ? $posts[0]->published_at->format('F d, Y') : $posts[0]->created_at->format('F d, Y') }}</span>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                                <a href="{{ route('posts.show', $posts[0]->slug) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $posts[0]->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-6 line-clamp-3">{{ $posts[0]->excerpt }}</p>
                            <div class="mt-auto">
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                        <span class="text-gray-700 font-medium">{{ substr($posts[0]->user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-700">{{ $posts[0]->user->name }}</span>
                                </div>
                                <a href="{{ route('posts.show', $posts[0]->slug) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                                    Read Article
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section divider -->
            <div class="flex items-center mb-12">
                <div class="flex-grow h-px bg-gray-200"></div>
                <h2 class="text-2xl font-bold text-gray-900 px-4">Latest Articles</h2>
                <div class="flex-grow h-px bg-gray-200"></div>
            </div>

            <!-- Blog post grid - clean, consistent cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $index => $post)
                    @if($index > 0)
                        <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="h-48 overflow-hidden bg-gray-200">
                                @if($post->featured_image)
                                    <a href="{{ route('posts.show', $post->slug) }}" class="block h-full">
                                        <img 
                                            src="{{ asset('storage/' . $post->featured_image) }}" 
                                            alt="{{ $post->title }}" 
                                            class="post-image w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                            data-type="post"
                                            data-post-id="{{ $post->id }}"
                                        >
                                    </a>
                                @else
                                    <a href="{{ route('posts.show', $post->slug) }}" class="block h-full flex items-center justify-center">
                                        <div class="text-gray-400 text-center p-4">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p>No image</p>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->user->name }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                
                                @if($post->hashtags)
                                    <div class="mb-4 flex flex-wrap">
                                        @foreach(explode(',', $post->hashtags) as $tag)
                                            <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-medium text-gray-700 mr-2 mb-2">
                                                #{{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center text-sm">
                                    Continue Reading
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @else
            <!-- Empty state with illustration -->
            <div class="py-16 text-center">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">We're working on creating amazing travel content. Check back soon for travel stories and tips.</p>
                <a href="{{ route('destinations') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                    Explore Destinations
                </a>
            </div>
        @endif

        <!-- Pagination -->
        @if(isset($posts) && $posts->hasPages())
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif

        <!-- Newsletter - clean, modern design -->
        <div class="mt-20 bg-gray-50 rounded-lg p-8 md:p-10">
            <div class="md:flex items-center justify-between max-w-5xl mx-auto">
                <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Stay updated</h3>
                    <p class="text-gray-600">Subscribe to our newsletter for the latest travel guides, tips, and inspiration.</p>
                </div>
                <div class="md:w-1/2">
                    <form class="flex flex-col sm:flex-row">
                        <input 
                            type="email" 
                            placeholder="Your email address" 
                            class="w-full px-4 py-3 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-3 sm:mb-0 sm:mr-3"
                            required
                        >
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto whitespace-nowrap px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors"
                        >
                            Subscribe
                        </button>
                    </form>
                    <p class="mt-3 text-xs text-gray-500">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>










