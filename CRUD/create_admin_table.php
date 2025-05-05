<?php
require '../db_connect.php';

try {
    // SQL to create admins table
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Admins table created successfully!<br>";
    
    // Optionally add a default admin user (remove after first use)
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    echo "Default admin user created (username: admin, password: admin123) - CHANGE THESE CREDENTIALS IMMEDIATELY!";
    
} catch(PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}