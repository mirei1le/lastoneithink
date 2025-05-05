<?php
session_start();
require '../db_connect_pdo.php'; // Changed to PDO connection

try {
    $sql = "SELECT * FROM products";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h2>Product List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price (€)</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['product_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['category_id']) ?></td>
            <td>€<?= htmlspecialchars($row['price']) ?></td>
            <td><?= htmlspecialchars($row['stock_quantity']) ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> |
                <a href="delete_product.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>