<?php
session_start();
require '../db_connect_pdo.php';

if (!isset($_GET["id"])) {
    die("Order ID not provided.");
}

try {
    $order_id = $_GET["id"];
    
    // Get order details
    $sql = "SELECT * FROM orders WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch();

    if (!$order) {
        die("Order not found.");
    }

    // Get order items
    $sql = "SELECT oi.*, p.name, p.image 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetchAll();

} catch(PDOException $e) {
    die("Error fetching order details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h2>Order #<?= htmlspecialchars($order['order_id']) ?></h2>
    
    <div class="order-info">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
        <p><strong>Date:</strong> <?= date('M j, Y H:i', strtotime($order['order_date'])) ?></p>
        <p><strong>Total:</strong> €<?= number_format($order['total_amount'], 2) ?></p>
        
        <h3>Shipping Address</h3>
        <p><?= htmlspecialchars($order['shipping_address']) ?><br>
        <?= htmlspecialchars($order['shipping_city']) ?>, <?= htmlspecialchars($order['shipping_zip']) ?><br>
        <?= htmlspecialchars($order['shipping_country']) ?></p>
    </div>
    
    <h3>Order Items</h3>
    <table border="1">
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><img src="../IMG/<?= htmlspecialchars($item['image']) ?>" width="50"></td>
            <td>€<?= number_format($item['price'], 2) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td>€<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
            <td><strong>€<?= number_format($order['total_amount'], 2) ?></strong></td>
        </tr>
    </table>
    
    <a href="view_orders.php">Back to Orders</a>
</body>
</html>