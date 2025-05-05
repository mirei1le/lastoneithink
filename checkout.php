<?php
session_start();
include 'db_connect.php';

// Check if cart is empty or invalid
if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $errors = array();
    $required_fields = ['name', 'email', 'address', 'city', 'zip', 'country'];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }
    
    if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // If no errors, process order
    if (empty($errors)) {
        // Calculate total with validation
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $item) {
            if (is_array($item) && isset($item['price'], $item['quantity'])) {
                $price = is_numeric($item['price']) ? (float)$item['price'] : 0;
                $quantity = is_numeric($item['quantity']) ? (int)$item['quantity'] : 0;
                $total += $price * $quantity;
            }
        }
        
        try {
            // Insert order
            $sql = "INSERT INTO orders (customer_name, customer_email, shipping_address, shipping_city, shipping_zip, shipping_country, total_amount) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssd", 
                $_POST['name'],
                $_POST['email'],
                $_POST['address'],
                $_POST['city'],
                $_POST['zip'],
                $_POST['country'],
                $total
            );
            $stmt->execute();
            $order_id = $conn->insert_id;
            
            // Insert order items with validation
            foreach ($_SESSION['cart'] as $product_id => $item) {
                if (is_array($item) && isset($item['price'], $item['quantity'])) {
                    $product_id = (int)$product_id;
                    $quantity = (int)$item['quantity'];
                    $price = (float)$item['price'];
                    
                    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiid", 
                        $order_id,
                        $product_id,
                        $quantity,
                        $price
                    );
                    $stmt->execute();
                }
            }
            
            // Clear cart
            unset($_SESSION['cart']);
            
            // Redirect to thank you page
            header("Location: thank_you.php?order_id=" . $order_id);
            exit();
        } catch (Exception $e) {
            $errors[] = "An error occurred while processing your order. Please try again.";
        }
    }
}

// Calculate cart total with validation
$total = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        if (is_array($item) && isset($item['price'], $item['quantity'])) {
            $price = is_numeric($item['price']) ? (float)$item['price'] : 0;
            $quantity = is_numeric($item['quantity']) ? (int)$item['quantity'] : 0;
            $total += $price * $quantity;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Shopaholics</title>
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

    <div class="checkout-container">
        <h1>Checkout</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="checkout-grid">
            <div class="checkout-form">
                <h2>Shipping Information</h2>
                <form action="checkout.php" method="post">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required 
                               value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" required 
                               value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="zip">ZIP Code</label>
                        <input type="text" id="zip" name="zip" required 
                               value="<?php echo isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" required 
                               value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; ?>">
                    </div>
                    
                    <h2>Payment Method</h2>
                    <div class="form-group">
                        <input type="radio" id="credit" name="payment" value="Credit Card" checked>
                        <label for="credit">Credit Card</label>
                    </div>
                    <div class="form-group">
                        <input type="radio" id="paypal" name="payment" value="PayPal">
                        <label for="paypal">PayPal</label>
                    </div>
                    
                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            </div>
            
            <div class="order-summary">
                <h2>Order Summary</h2>
                <ul>
                    <?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <?php if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'], $item['image'])): ?>
                                <li>
                                    <img src="IMG/<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>" width="50">
                                    <?php echo htmlspecialchars($item['name']); ?> × <?php echo (int)$item['quantity']; ?>
                                    <span>€<?php echo number_format((float)$item['price'] * (int)$item['quantity'], 2); ?></span>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="order-total">
                    <strong>Total: €<?php echo number_format($total, 2); ?></strong>
                </div>
            </div>
        </div>
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