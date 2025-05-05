// Product Modal Functions
function showProductModal(product) {
    const modal = document.getElementById('productModal');
    // Store product data in modal for later use
    modal.dataset.productId = product.product_id;
    modal.dataset.productPrice = product.price;
    
    // Reset quantity to 1 when showing a new product
    document.querySelector('.quantity-input').value = 1;
    
    document.getElementById('modalProductName').textContent = product.name;
    document.getElementById('modalProductImage').src = 'IMG/' + product.image;
    document.getElementById('modalProductPrice').textContent = '€' + parseFloat(product.price).toFixed(2);
    document.getElementById('modalProductDescription').textContent = product.description || 'Product description';
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    document.getElementById('productModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Add to Cart from Modal
function addToCartFromModal() {
    const modal = document.getElementById('productModal');
    const productId = modal.dataset.productId;
    const quantity = parseInt(document.querySelector('.quantity-input').value);
    const price = parseFloat(modal.dataset.productPrice);
    
    // Create a form and submit it
    const form = document.createElement('form');
    form.method = 'get';
    form.action = 'cart.php';
    
    const productInput = document.createElement('input');
    productInput.type = 'hidden';
    productInput.name = 'add_to_cart';
    productInput.value = productId;
    form.appendChild(productInput);
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantity';
    quantityInput.value = quantity;
    form.appendChild(quantityInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    document.getElementById('productModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeProductModal();
        }
    });
    
    // Quantity buttons
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('quantity-btn')) {
            const input = event.target.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value);
            
            if (event.target.classList.contains('minus') && value > 1) {
                input.value = value - 1;
            } else if (event.target.classList.contains('plus')) {
                input.value = value + 1;
            }
        }
    });
    
    // Add to Cart button in modal
    document.querySelector('.add-to-cart-btn').addEventListener('click', addToCartFromModal);
});