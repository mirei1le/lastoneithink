<?php
session_start();
require '../db_connect_pdo.php';

if (!isset($_GET["id"])) {
    die("User ID is missing.");
}

try {
    $user_id = $_GET["id"];
    $sql = "DELETE FROM users WHERE user_ID = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: view_users.php");
        exit();
    }
} catch(PDOException $e) {
    echo "Error deleting user: " . $e->getMessage();
}
?>