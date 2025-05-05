<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $reviewer_name = trim($_POST['reviewer_name']);
    $rating = intval($_POST['rating']);
    $review_text = trim($_POST['review_text']);
    
    // Set user_ID to NULL for anonymous reviews or user's ID if logged in
    $user_ID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    // Validate input
    if (empty($reviewer_name)) {
        $_SESSION['review_error'] = "Please enter your name";
        header("Location: homeStore.php?product_id=$product_id#reviews");
        exit();
    }

    if ($rating < 1 || $rating > 5) {
        $_SESSION['review_error'] = "Please select a valid rating (1-5 stars)";
        header("Location: homeStore.php?product_id=$product_id#reviews");
        exit();
    }

    if (empty($review_text)) {
        $_SESSION['review_error'] = "Please write your review";
        header("Location: homeStore.php?product_id=$product_id#reviews");
        exit();
    }

    // Insert review
    $sql = "INSERT INTO reviews (user_ID, reviewer_name, product_id, rating, review_text) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Handle NULL user_ID differently in binding
    if ($user_ID !== NULL) {
        $stmt->bind_param("isiss", $user_ID, $reviewer_name, $product_id, $rating, $review_text);
    } else {
        // For NULL user_ID, we need to bind differently
        $null = NULL;
        $stmt->bind_param("isiss", $null, $reviewer_name, $product_id, $rating, $review_text);
    }

    if ($stmt->execute()) {
        $_SESSION['review_success'] = "Thank you for your review!";
    } else {
        $_SESSION['review_error'] = "Error submitting review. Please try again. Error: " . $stmt->error;
    }

    header("Location: homeStore.php?product_id=$product_id#reviews");
    exit();
} else {
    header("Location: homeStore.php");
    exit();
}