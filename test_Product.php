<?php
// Test Case for Product class

require_once 'Product.php'; // Include the Product class

// Create an instance of Product
$product = new Product();

// Set values
$product->setProductID(101);
$product->setName("iPhone 16 Pro Max");
$product->setDescription("The latest iPhone model with advanced features");
$product->setPrice(1499.99);
$product->setStock(25);

// Perform tests
$test1 = $product->getProductID() === 101;
$test2 = $product->getName() === "iPhone 16 Pro Max";
$test3 = $product->getDescription() === "The latest iPhone model with advanced features";
$test4 = $product->getPrice() === 1499.99;
$test5 = $product->getStock() === 25;

// Display result
if ($test1 && $test2 && $test3 && $test4 && $test5) {
    echo "test_Product PASSED";
} else {
    echo "test_Product FAILED";
}
?>
