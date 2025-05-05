<?php
// db_connect_pdo.php - PDO connection for CRUD operations only
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "department_store";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}
?>