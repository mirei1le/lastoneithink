<?php
session_start();
require '../db_connect_pdo.php';

try {
    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $stmt = $pdo->query($sql);
    $orders = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Error fetching orders: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h2>Order List</h2>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['order_id']) ?></td>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['customer_email']) ?></td>
            <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
            <td>€<?= number_format($order['total_amount'], 2) ?></td>
            <td>
                <a href="view_order_details.php?id=<?= $order['order_id'] ?>">View</a> |
                <a href="delete_order.php?id=<?= $order['order_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>