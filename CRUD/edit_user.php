<?php
session_start();
require '../db_connect_pdo.php';

if (!isset($_GET["id"])) {
    die("User ID not provided.");
}

try {
    $user_id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE user_ID = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        die("User not found.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $dob = $_POST["dob"];

        $sql = "UPDATE users SET 
                username = :username, 
                email = :email, 
                dob = :dob 
                WHERE user_ID = :user_id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: view_users.php");
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
    <title>Edit User</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body>
    <h2>Edit User</h2>
    <form action="" method="POST">
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>