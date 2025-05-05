<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['order_id'])) {
    header("Location: homeStore.php");
    exit();
}

$order_id = $_GET['order_id'];

// Get order details
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Get order items
$sql = "SELECT oi.*, p.name, p.image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Shopaholics</title>
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

    <div class="thank-you-container">
        <h1>Thank You for Your Order!</h1>
        <p>Your order #<?php echo $order_id; ?> has been placed successfully.</p>
        <p>A confirmation email has been sent to <?php echo htmlspecialchars($order['customer_email']); ?>.</p>
        
        <div class="order-details">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> #<?php echo $order_id; ?></p>
            <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($order['order_date'])); ?></p>
            <p><strong>Total:</strong> €<?php echo number_format($order['total_amount'], 2); ?></p>
            <p><strong>Shipping to:</strong> 
                <?php echo htmlspecialchars($order['customer_name']); ?><br>
                <?php echo htmlspecialchars($order['shipping_address']); ?><br>
                <?php echo htmlspecialchars($order['shipping_city']); ?>, 
                <?php echo htmlspecialchars($order['shipping_zip']); ?><br>
                <?php echo htmlspecialchars($order['shipping_country']); ?>
            </p>
            
            <h3>Items Ordered</h3>
            <ul>
                <?php while ($item = $items->fetch_assoc()): ?>
                    <li>
                        <img src="IMG/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50">
                        <?php echo htmlspecialchars($item['name']); ?> × <?php echo $item['quantity']; ?>
                        <span>€<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        
        <a href="homeStore.php" class="continue-shopping">Continue Shopping</a>
    </div>

    <!-- FOOTER (same as homeStore.php) -->
    <footer>
        <!-- Your footer code from homeStore.php -->
    </footer>
</body>
</html>