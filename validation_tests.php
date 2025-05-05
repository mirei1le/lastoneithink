<?php
// Part C - Validation Tests (All in One File)

$errors = [];

// Simulated Form Data
$_POST['username'] = "admin"; // Try "" to test required
$_POST['password'] = "pass"; // Try "pass" to test short password
$_POST['email'] = "adminexample.com"; // Try missing @ to test email
$_POST['password_with_number'] = "Password"; // Try password missing a number

// -------------------------
// Test 1: Username is Required
// -------------------------
if (empty($_POST['username'])) {
    $errors[] = "Test 1 FAILED: Username is required.";
} else {
    echo "Test 1 PASSED: Username is filled.<br>";
}

// -------------------------
// Test 2: Password is Required
// -------------------------
if (empty($_POST['password'])) {
    $errors[] = "Test 2 FAILED: Password is required.";
} else {
    echo "Test 2 PASSED: Password is filled.<br>";
}

// -------------------------
// Test 3: Password Must Be at Least 8 Characters
// -------------------------
if (strlen($_POST['password']) < 8) {
    $errors[] = "Test 3 FAILED: Password must be at least 8 characters.";
} else {
    echo "Test 3 PASSED: Password length is good.<br>";
}

// -------------------------
// Test 4: Email Must Be a Valid Format
// -------------------------
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Test 4 FAILED: Invalid email format.";
} else {
    echo "Test 4 PASSED: Email format is valid.<br>";
}

// -------------------------
// Test 5: Password Must Contain At Least One Number
// -------------------------
if (!preg_match('/[0-9]/', $_POST['password_with_number'])) {
    $errors[] = "Test 5 FAILED: Password must include at least one number.";
} else {
    echo "Test 5 PASSED: Password includes a number.<br>";
}

// -------------------------
// Output Overall Result
// -------------------------
if (empty($errors)) {
    echo "<br>All Validation Tests Passed ✅";
} else {
    echo "<br><br>";
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
