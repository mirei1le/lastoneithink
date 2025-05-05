<?php
// db_connect.php - MySQLi connection only
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$database = "department_store";

// MySQLi Connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("MySQLi Connection failed: " . $conn->connect_error);
}
?>