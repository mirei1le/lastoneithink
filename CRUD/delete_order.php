<?php
session_start();
require '../db_connect_pdo.php';

if (!isset($_GET["id"])) {
    die("Order ID is missing.");
}

try {
    $order_id = $_GET["id"];
    
    // First delete order items
    $sql = "DELETE FROM order_items WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Then delete the order
    $sql = "DELETE FROM orders WHERE order_id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: view_orders.php");
        exit();
    }
} catch(PDOException $e) {
    echo "Error deleting order: " . $e->getMessage();
}
?>