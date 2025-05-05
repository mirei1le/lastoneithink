<?php
// Test Case for Review class

require_once 'Review.php'; // Include the Review class

// Create an instance of Review
$review = new Review();

// Set values
$review->setReviewID(301);
$review->setUserID(1);
$review->setProductID(101);
$review->setRating(5);
$review->setReviewText("Amazing product, highly recommend!");
$review->setReviewDate("2025-04-27");

// Perform tests
$test1 = $review->getReviewID() === 301;
$test2 = $review->getUserID() === 1;
$test3 = $review->getProductID() === 101;
$test4 = $review->getRating() === 5;
$test5 = $review->getReviewText() === "Amazing product, highly recommend!";
$test6 = $review->getReviewDate() === "2025-04-27";

// Display result
if ($test1 && $test2 && $test3 && $test4 && $test5 && $test6) {
    echo "test_Review PASSED";
} else {
    echo "test_Review FAILED";
}
?>
