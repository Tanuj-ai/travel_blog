// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    // Find all post images
    const postImages = document.querySelectorAll('.post-image');
    
    // Add error handling to each image
    postImages.forEach(img => {
        // Set up error handler
        img.onerror = function() {
            // Get post title from alt text or parent element
            const postTitle = this.alt || this.closest('article')?.querySelector('h3')?.textContent || '';
            const encodedTitle = encodeURIComponent(postTitle.toLowerCase());
            
            // Set the Unsplash image based on post title
            this.src = `https://source.unsplash.com/random/800x600/?${encodedTitle}`;
            
            // If that fails, use a completely random image
            this.onerror = function() {
                this.src = 'https://source.unsplash.com/random/800x600';
                this.onerror = null;
            };
            
            console.log(`Using Unsplash image for: ${postTitle}`);
        };
        
        // Force reload for images that might be cached in error state
        if (img.complete) {
            if (img.naturalHeight === 0) {
                // Image is already in error state, trigger onerror manually
                img.onerror();
            }
        }
    });
    
    // Special handling for the Northern Lights post
    const northernLightsCards = document.querySelectorAll('article h3 a');
    northernLightsCards.forEach(link => {
        if (link.textContent.trim().includes('Northern Lights') || 
            link.textContent.trim().includes('Aurora') || 
            link.textContent.trim().includes('Iceland')) {
            
            console.log('Found Northern Lights post, using specific image');
            
            // Find the image in this card
            const card = link.closest('article');
            if (card) {
                const img = card.querySelector('img');
                if (img) {
                    // Use a specific Unsplash image for Northern Lights
                    img.src = 'https://source.unsplash.com/random/800x600/?northern,lights,aurora,iceland';
                }
            }
        }
    });
    
    console.log('Image fallback handlers initialized');
});

