<?php
// Test Case for Orders class

require_once 'Orders.php'; // Include the Orders class

// Create an instance of Orders
$order = new Orders();

// Set values
$order->setOrderID(501);
$order->setUserID(1);
$order->setTotalPrice(299.99);
$order->setOrderStatus("Pending");

// Perform tests
$test1 = $order->getOrderID() === 501;
$test2 = $order->getUserID() === 1;
$test3 = $order->getTotalPrice() === 299.99;
$test4 = $order->getOrderStatus() === "Pending";

// Display result
if ($test1 && $test2 && $test3 && $test4) {
    echo "test_Orders PASSED";
} else {
    echo "test_Orders FAILED";
}
?>
