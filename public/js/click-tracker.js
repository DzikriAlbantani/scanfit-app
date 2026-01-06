/**
 * Product Click Tracker
 * 
 * Optionally track product clicks via AJAX before navigation.
 * Usage: Add data-product-id attribute to links
 * 
 * Example:
 * <a href="/products/123" data-product-id="123" class="track-click">Product</a>
 */

document.addEventListener('DOMContentLoaded', function() {
    // Track clicks on elements with .track-click class
    const trackableLinks = document.querySelectorAll('a[data-product-id].track-click');
    
    trackableLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const productId = this.dataset.productId;
            
            if (productId) {
                // Send tracking request (non-blocking)
                fetch(`/products/${productId}/track-click`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ tracked: true })
                }).catch(() => {
                    // Silently fail - don't block navigation
                });
            }
        });
    });
});
