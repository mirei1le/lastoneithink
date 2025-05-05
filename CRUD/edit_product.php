<?php
session_start();
require '../db_connect_pdo.php'; // Changed to PDO connection

if (!isset($_GET["id"])) {
    die("Product ID not provided.");
}

try {
    $product_id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();

    if (!$product) {
        die("Product not found.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $category_id = $_POST["category_id"];
        $price = $_POST["price"];
        $stock_quantity = $_POST["stock_quantity"];
        $description = $_POST["description"];

        $sql = "UPDATE products SET 
                name = :name, 
                category_id = :category_id, 
                price = :price, 
                stock_quantity = :stock_quantity, 
                description = :description 
                WHERE product_id = :product_id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: view_products.php");
            exit();
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h2>Edit Product</h2>
    <form action="" method="POST">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <input type="number" name="category_id" value="<?= htmlspecialchars($product['category_id']) ?>" required>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
        <input type="number" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        <button type="submit">Update</button>
    </form>
</body>
</html>