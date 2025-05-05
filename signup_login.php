<?php
session_start();
require 'db_connect.php';

// Initialize error/success messages
$_SESSION['login_error'] = '';
$_SESSION['signup_error'] = '';
$_SESSION['signup_success'] = '';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please fill in all fields";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['login_error'] = "Account not found";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user["password"])) {
        // Login successful - set session variables
        $_SESSION["user_id"] = $user["user_ID"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["logged_in"] = true;
        
        // Redirect to home page or previous page
        $redirect = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
        unset($_SESSION['redirect_url']);
        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid email or password";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    // Sanitize and validate inputs
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $dob = $_POST["dob"] ?? '';

    // Validate inputs
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Full Name is required";
    } elseif (strlen($username) > 50) {
        $errors[] = "Full Name must be less than 50 characters";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } elseif (strlen($email) > 100) {
        $errors[] = "Email must be less than 100 characters";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    if (empty($dob)) {
        $errors[] = "Date of Birth is required";
    } elseif (strtotime($dob) > strtotime('-13 years')) {
        $errors[] = "You must be at least 13 years old";
    }

    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode("<br>", $errors);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = "Email already registered";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, dob) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $dob);

    if ($stmt->execute()) {
        // Get the new user's ID
        $user_id = $conn->insert_id;
        
        // Set session variables
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["logged_in"] = true;
        
        $_SESSION['signup_success'] = "Registration successful! You are now logged in.";
        
        // Redirect to home page
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['signup_error'] = "Error: " . $conn->error;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// If directly accessed, redirect to home page
header("Location: index.php");
exit();
?>