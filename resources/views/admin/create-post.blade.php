<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                                         :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="excerpt" :value="__('Excerpt')" />
                            <x-text-input id="excerpt" name="excerpt" type="text" class="mt-1 block w-full" 
                                         :value="old('excerpt')" />
                            <p class="mt-1 text-sm text-gray-500">A short summary of your post</p>
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="10" 
                                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                     required>{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="hashtags" :value="__('Hashtags')" />
                            <x-text-input id="hashtags" name="hashtags" type="text" class="mt-1 block w-full" 
                                         :value="old('hashtags')" placeholder="travel, adventure, bali" />
                            <p class="mt-1 text-sm text-gray-500">Separate hashtags with commas</p>
                            <x-input-error :messages="$errors->get('hashtags')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            <input id="featured_image" name="featured_image" type="file" 
                                  class="mt-1 block w-full text-sm text-gray-500
                                         file:mr-4 file:py-2 file:px-4
                                         file:rounded-md file:border-0
                                         file:text-sm file:font-semibold
                                         file:bg-indigo-50 file:text-indigo-700
                                         hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.posts') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Create Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

