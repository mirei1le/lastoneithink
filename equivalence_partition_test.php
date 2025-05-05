<?php
// Equivalence Partition Test for Password Length

function validatePassword($password) {
    if (strlen($password) == 0) {
        return "Invalid: Password cannot be empty.";
    } elseif (strlen($password) < 8) {
        return "Invalid: Password too short.";
    } elseif (strlen($password) > 20) {
        return "Invalid: Password too long.";
    } else {
        return "Valid Password.";
    }
}

// Test cases
echo validatePassword("") . "<br>";            // 0 characters
echo validatePassword("pass") . "<br>";         // 4 characters
echo validatePassword("goodPass123") . "<br>";  // 11 characters
echo validatePassword(str_repeat("a", 25)) . "<br>"; // 25 characters
?>
