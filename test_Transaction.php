<?php
// Test Case for Transaction class

require_once 'Transaction.php'; // Include the Transaction class

// Create an instance of Transaction
$transaction = new Transaction();

// Set values
$transaction->setTransactionID(1001);
$transaction->setUserID(1);
$transaction->setProductID(101);
$transaction->setQuantity(2);
$transaction->setTotalPrice(2999.98);
$transaction->setPaymentMethod("Credit Card");
$transaction->setTransactionDate("2025-04-27");
$transaction->setStatus("Completed");

// Perform tests
$test1 = $transaction->getTransactionID() === 1001;
$test2 = $transaction->getUserID() === 1;
$test3 = $transaction->getProductID() === 101;
$test4 = $transaction->getQuantity() === 2;
$test5 = $transaction->getTotalPrice() === 2999.98;
$test6 = $transaction->getPaymentMethod() === "Credit Card";
$test7 = $transaction->getTransactionDate() === "2025-04-27";
$test8 = $transaction->getStatus() === "Completed";

// Display result
if ($test1 && $test2 && $test3 && $test4 && $test5 && $test6 && $test7 && $test8) {
    echo "test_Transaction PASSED";
} else {
    echo "test_Transaction FAILED";
}
?>
