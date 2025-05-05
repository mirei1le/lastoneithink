<?php
// Test Case for User class

require_once 'User.php'; // Include the User class

// Create an instance of the User
$user = new User();

// Set values
$user->setUserID(1);
$user->setFullName("John Doe");
$user->setEmail("johndoe@example.com");
$user->setPassword("securepassword123");
$user->setDob("2000-01-01");
$user->setRole("admin");

// Perform tests
$test1 = $user->getUserID() === 1;
$test2 = $user->getFullName() === "John Doe";
$test3 = $user->getEmail() === "johndoe@example.com";
$test4 = $user->getPassword() === "securepassword123";
$test5 = $user->getDob() === "2000-01-01";
$test6 = $user->getRole() === "admin";

// Display result
if ($test1 && $test2 && $test3 && $test4 && $test5 && $test6) {
    echo "test_User PASSED";
} else {
    echo "test_User FAILED";
}
?>
