<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                                         :value="old('title', $post->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="excerpt" :value="__('Excerpt')" />
                            <textarea id="excerpt" name="excerpt" rows="3" 
                                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('excerpt', $post->excerpt) }}</textarea>
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="10" 
                                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content', $post->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            
                            @if($post->featured_image)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current image:</p>
                                    <img src="{{ asset($post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-64 h-auto rounded"
                                         onerror="this.src='{{ asset('images/default-featured.jpg') }}'; this.onerror=null;">
                                </div>
                            @endif
                            
                            <div class="mt-2">
                                <div class="flex flex-col space-y-2">
                                    <div>
                                        <input id="featured_image" name="featured_image" type="file" accept="image/*" 
                                              class="mt-1 block w-full" />
                                        <p class="mt-1 text-sm text-gray-500">Upload a new image (recommended size: 1200x800 pixels)</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 mb-2">Or select from blog images:</p>
                                        <div class="flex items-center">
                                            <input type="text" id="image_path" name="image_path" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                   placeholder="Image path (e.g., images/blog/travel/travel-1.jpg)" />
                                            <a href="{{ route('admin.blog-images') }}" target="_blank" class="ml-2 text-blue-600 hover:text-blue-800">
                                                Browse
                                            </a>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Leave both empty to keep current image</p>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <button type="button" id="getRandomImage" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-1 px-3 rounded">
                                            Get Random Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="hashtags" :value="__('Hashtags')" />
                            <x-text-input id="hashtags" name="hashtags" type="text" class="mt-1 block w-full" 
                                         :value="old('hashtags', $post->hashtags)" placeholder="travel, adventure, bali" />
                            <p class="mt-1 text-sm text-gray-500">Separate hashtags with commas</p>
                            <x-input-error :messages="$errors->get('hashtags')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.posts') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const getRandomImageButton = document.getElementById('getRandomImage');
        const imagePathInput = document.getElementById('image_path');
        
        if (getRandomImageButton && imagePathInput) {
            getRandomImageButton.addEventListener('click', function() {
                const postId = {{ $post->id }};
                
                // Show loading state
                getRandomImageButton.textContent = 'Loading...';
                getRandomImageButton.disabled = true;
                
                // Make AJAX request to get random image
                fetch(`/admin/blog-images/random/${postId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            imagePathInput.value = data.image_path;
                            // Update preview image if it exists
                            const previewImg = document.querySelector('img[alt="{{ $post->title }}"]');
                            if (previewImg) {
                                previewImg.src = '/' + data.image_path;
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while getting a random image');
                    })
                    .finally(() => {
                        // Reset button state
                        getRandomImageButton.textContent = 'Get Random Image';
                        getRandomImageButton.disabled = false;
                    });
            });
        }
    });
</script>



