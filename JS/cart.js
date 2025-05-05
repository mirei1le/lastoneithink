document.addEventListener('DOMContentLoaded', () => {
    const cartIcon = document.querySelector('.cart-icon');
    const cartContent = document.querySelector('.cart-content');
    const cartItemsList = document.getElementById('cart-items');
    const cartCount = document.querySelector('.cart-count');
    const checkoutBtn = document.querySelector('.checkout-btn');

    // Toggle cart dropdown
    cartIcon.addEventListener('click', () => {
        cartContent.classList.toggle('show');
    });

    // Close cart when clicking outside
    document.addEventListener('click', (event) => {
        if (!cartIcon.contains(event.target) && !cartContent.contains(event.target)) {
            cartContent.classList.remove('show');
        }
    });

    // Add to cart functionality
    document.querySelectorAll('.add-to-bag').forEach(button => {
        button.addEventListener('click', (e) => {
            const productId = e.target.dataset.productId;
            
            // Send AJAX request to add product to cart
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartDisplay(data);
                } else {
                    alert('Failed to add product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Function to update cart display
    function updateCartDisplay(cartData) {
        // Clear existing cart items
        cartItemsList.innerHTML = '';

        // Update cart count
        cartCount.textContent = cartData.total_quantity;

        // Populate cart items
        if (cartData.items && cartData.items.length > 0) {
            cartData.items.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <img src="IMG/${item.image}" alt="${item.name}">
                    <div>
                        <p>${item.name}</p>
                        <p>€${item.price} x ${item.quantity}</p>
                        <button class="remove-item" data-product-id="${item.product_id}">Remove</button>
                    </div>
                `;
                cartItemsList.appendChild(li);
            });

            // Remove item buttons
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', (e) => {
                    const productId = e.target.dataset.productId;
                    
                    fetch('remove_from_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `product_id=${productId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartDisplay(data);
                        }
                    });
                });
            });

            // Show checkout button
            document.querySelector('.empty-cart').style.display = 'none';
            checkoutBtn.style.display = 'block';
        } else {
            // Show empty cart message
            document.querySelector('.empty-cart').style.display = 'block';
            checkoutBtn.style.display = 'none';
        }
    }

    // Initial cart load
    function loadCart() {
        fetch('get_cart.php')
        .then(response => response.json())
        .then(data => {
            updateCartDisplay(data);
        });
    }

    // Load cart on page load
    loadCart();
});