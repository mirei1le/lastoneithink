<?php
session_start();
include 'db_connect.php';

// Add item to cart
if (isset($_GET['add_to_cart'])) {
    $product_id = filter_var($_GET['add_to_cart'], FILTER_VALIDATE_INT);
    
    if ($product_id !== false && $product_id > 0) {
        // Get product details from database
        $sql = "SELECT name, price, image FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            
            // Initialize cart if not exists
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            // Add or update item in cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'] ?? 'Unknown Product',
                    'price' => $product['price'] ?? 0,
                    'image' => $product['image'] ?? '',
                    'quantity' => 1
                ];
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $product_id = filter_var($_GET['remove'], FILTER_VALIDATE_INT);
    if ($product_id !== false && $product_id > 0 && isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit();
}

// Update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            $product_id = filter_var($product_id, FILTER_VALIDATE_INT);
            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            
            if ($product_id !== false && $quantity !== false && $quantity > 0 && 
                isset($_SESSION['cart'][$product_id]) && is_array($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            }
        }
    }
    header("Location: cart.php");
    exit();
}

// Calculate totals
$grand_total = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        if (is_array($item) && isset($item['price'], $item['quantity'])) {
            $item_price = is_numeric($item['price']) ? (float)$item['price'] : 0;
            $item_quantity = is_numeric($item['quantity']) ? (int)$item['quantity'] : 0;
            $grand_total += $item_price * $item_quantity;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Shopaholics</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <!-- HEADER & NAVIGATION (same as homeStore.php) -->
    <header>
        <h3 class="promo"> USE CODE [NEW2025] FOR EXTRA UP TO 20% SKINCARE PRODUCTS </h3>
    </header>
    
    <nav>
        <!-- Your navigation code from homeStore.php -->
    </nav>

    <div class="cart-container">
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])): ?>
            <p class="empty-cart">Your cart is empty.</p>
            <a href="homeStore.php" class="continue-shopping">Continue Shopping</a>
        <?php else: ?>
            <form action="cart.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <?php 
                            if (!is_array($item) || !isset($item['price'], $item['quantity'], $item['name'])) {
                                continue; // Skip invalid items
                            }
                            
                            $item_price = is_numeric($item['price']) ? (float)$item['price'] : 0;
                            $item_quantity = is_numeric($item['quantity']) ? (int)$item['quantity'] : 0;
                            $item_total = $item_price * $item_quantity;
                            $item_name = htmlspecialchars($item['name'] ?? 'Unknown Product');
                            $item_image = htmlspecialchars($item['image'] ?? '');
                            ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item_image)): ?>
                                        <img src="IMG/<?php echo $item_image; ?>" alt="<?php echo $item_name; ?>" class="product-image">
                                    <?php endif; ?>
                                    <?php echo $item_name; ?>
                                </td>
                                <td>€<?php echo number_format($item_price, 2); ?></td>
                                <td>
                                    <input type="number" name="quantities[<?php echo (int)$product_id; ?>]" 
                                           value="<?php echo $item_quantity; ?>" min="1" class="quantity-input">
                                </td>
                                <td>€<?php echo number_format($item_total, 2); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo (int)$product_id; ?>" class="remove-btn">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                            <td colspan="2">€<?php echo number_format($grand_total, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="update-btn">Update Cart</button>
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- FOOTER (same as homeStore.php) -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Shopaholics - Your go-to store for tech, skincare, and more.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="technology.php">Technology</a></li>
                    <li><a href="skincare.php">Skincare</a></li>
                    <li><a href="makeup.php">Makeup</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Meet your Owners</h3>
                <p>Cheryl Donga</p>
                <p>Mireille Aka</p>
                <p>Vivien Obi</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <p class="footer-bottom">&copy; 2025 Shopaholics. All rights reserved.</p>
    </footer>
</body>
</html>