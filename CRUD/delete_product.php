<?php
session_start();
require '../db_connect_pdo.php'; // Changed to PDO connection

if (!isset($_GET["id"])) {
    die("Product ID is missing.");
}

try {
    $product_id = $_GET["id"];
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: view_products.php");
        exit();
    }
} catch(PDOException $e) {
    echo "Error deleting product: " . $e->getMessage();
}
?>