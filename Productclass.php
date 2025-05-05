<?php
class Product {
    private $id;
    private $name;
    private $category_id;
    private $price;
    private $stock_quantity;
    private $image;
    private $description;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all products
    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
