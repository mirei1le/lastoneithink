<?php
require_once 'db_connect.php';
require_once 'Productclass.php';

abstract class BaseTest {
    protected $connection;
    protected $product;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->product = new Product($this->connection);
    }

    // Common setup method
    protected function setUp() {
        // Initialize session if needed
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = []; // Clear session for testing
    }

    // Common teardown method
    protected function tearDown() {
        // Clean up session
        $_SESSION = [];
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    // Common assertion methods
    protected function assertTrue($condition, $message = '') {
        if (!$condition) {
            throw new Exception("Assertion failed: " . $message);
        }
    }

    protected function assertFalse($condition, $message = '') {
        $this->assertTrue(!$condition, $message);
    }

    protected function assertEquals($expected, $actual, $message = '') {
        if ($expected != $actual) {
            throw new Exception(sprintf(
                "Assertion failed: Expected %s, got %s. %s",
                print_r($expected, true),
                print_r($actual, true),
                $message
            );
        }
    }

    abstract public function runTests();
}
?>