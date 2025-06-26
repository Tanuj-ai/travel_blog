<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog Images') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Available Blog Images</h3>
                    
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-2">These images can be assigned to blog posts. Click on an image to copy its path.</p>
                        
                        <div class="mt-4 flex space-x-4">
                            <button id="removeAllImages" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                Remove All Images from Posts
                            </button>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-800 mb-2">Filter by Category:</h4>
                        <div class="flex flex-wrap gap-2">
                            <button class="category-filter px-4 py-2 bg-blue-600 text-white rounded-md" data-category="all">All</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="special">Special</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="travel">Travel</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="nature">Nature</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="city">City</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="food">Food</button>
                            <button class="category-filter px-4 py-2 bg-gray-200 text-gray-800 rounded-md" data-category="people">People</button>
                        </div>
                    </div>
                    
                    <!-- Image Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($images as $image)
                            <div class="image-card" data-category="{{ $image['category'] }}">
                                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="h-40 overflow-hidden">
                                        <img src="{{ asset($image['path']) }}" alt="{{ $image['name'] }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-3">
                                        <p class="text-sm text-gray-600 truncate">{{ $image['name'] }}</p>
                                        <p class="text-xs text-gray-500">Category: {{ $image['category'] }}</p>
                                        <div class="mt-2 flex justify-between">
                                            <button class="copy-path text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded" data-path="{{ $image['path'] }}">
                                                Copy Path
                                            </button>
                                            <button class="preview-image text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded" data-path="{{ $image['path'] }}">
                                                Preview
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- No images message -->
                    @if(count($images) === 0)
                        <div class="text-center py-8">
                            <p class="text-gray-500">No images available. Run <code>php artisan blog:setup-images</code> to create default images.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Image Preview Modal -->
            <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg max-w-2xl w-full mx-4">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Image Preview</h3>
                        <button id="closePreviewModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <img id="previewImage" src="" alt="Preview" class="w-full h-auto max-h-96 object-contain">
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Image Path:</p>
                            <code id="previewImagePath" class="text-sm bg-gray-100 p-2 rounded block w-full overflow-x-auto"></code>
                        </div>
                        <div class="flex justify-end">
                            <button id="copyPathFromPreview" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                                Copy Path
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category filtering
            const categoryButtons = document.querySelectorAll('.category-filter');
            const imageCards = document.querySelectorAll('.image-card');
            
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    
                    // Update button styles
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('bg-blue-600', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-800');
                    });
                    this.classList.remove('bg-gray-200', 'text-gray-800');
                    this.classList.add('bg-blue-600', 'text-white');
                    
                    // Filter images
                    imageCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });
            });
            
            // Copy path functionality
            const copyButtons = document.querySelectorAll('.copy-path');
            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const path = this.getAttribute('data-path');
                    navigator.clipboard.writeText(path).then(() => {
                        // Show copied feedback
                        const originalText = this.textContent;
                        this.textContent = 'Copied!';
                        this.classList.remove('bg-blue-100', 'text-blue-700');
                        this.classList.add('bg-green-100', 'text-green-700');
                        
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('bg-green-100', 'text-green-700');
                            this.classList.add('bg-blue-100', 'text-blue-700');
                        }, 2000);
                    });
                });
            });
            
            // Image preview functionality
            const previewButtons = document.querySelectorAll('.preview-image');
            const previewModal = document.getElementById('imagePreviewModal');
            const previewImage = document.getElementById('previewImage');
            const previewImagePath = document.getElementById('previewImagePath');
            const closePreviewModal = document.getElementById('closePreviewModal');
            const copyPathFromPreview = document.getElementById('copyPathFromPreview');
            
            previewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const path = this.getAttribute('data-path');
                    previewImage.src = '/' + path;
                    previewImagePath.textContent = path;
                    previewModal.classList.remove('hidden');
                });
            });
            
            closePreviewModal.addEventListener('click', function() {
                previewModal.classList.add('hidden');
            });
            
            copyPathFromPreview.addEventListener('click', function() {
                navigator.clipboard.writeText(previewImagePath.textContent).then(() => {
                    this.textContent = 'Copied!';
                    setTimeout(() => {
                        this.textContent = 'Copy Path';
                    }, 2000);
                });
            });
            
            // Close modal when clicking outside
            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.add('hidden');
                }
            });

            // Remove all images functionality
            const removeAllImagesButton = document.getElementById('removeAllImages');
            if (removeAllImagesButton) {
                removeAllImagesButton.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove images from all blog posts? This action cannot be undone.')) {
                        // Show loading state
                        removeAllImagesButton.textContent = 'Processing...';
                        removeAllImagesButton.disabled = true;
                        
                        // Create a CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        // Make AJAX request to remove all images
                        fetch('/admin/blog-images/remove-all', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                            } else {
                                alert('Error: ' + (data.message || 'Failed to remove images'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while removing images');
                        })
                        .finally(() => {
                            // Reset button state
                            removeAllImagesButton.textContent = 'Remove All Images from Posts';
                            removeAllImagesButton.disabled = false;
                        });
                    }
                });
            }
        });
    </script>
</x-app-layout>

