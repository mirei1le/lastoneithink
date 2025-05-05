
<?php
session_start();
require '../db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h1>Admin Dashboard <a href="?logout" class="delete-link" style="float: right;">Logout</a></h1>
    <nav>
        <ul>
            <li><a href="add_product.php">Create Product</a></li>
            <li><a href="view_products.php">View Products</a></li>
            <li><a href="add_product.php">Create Product</a></li>
            <li><a href="view_products.php">View Products</a></li>
            <li><a href="view_users.php">Manage Users</a></li>
            <li><a href="view_orders.php">Manage Orders</a></li>
            </ul>
    </nav>
</body>
</html>
