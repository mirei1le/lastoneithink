<?php
session_start();
require '../db_connect_pdo.php'; // Changed to use PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = $_POST["name"];
        $category_id = $_POST["category_id"];
        $price = $_POST["price"];
        $stock_quantity = $_POST["stock_quantity"];
        $description = $_POST["description"];
        $image = $_POST["image"]; 

        $sql = "INSERT INTO products (name, category_id, price, stock_quantity, description, image) 
                VALUES (:name, :category_id, :price, :stock_quantity, :description, :image)";

        $stmt = $pdo->prepare($sql); // Using PDO here
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            echo "Product added successfully!";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>