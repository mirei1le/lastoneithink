<?php
class Product {
    private $productID;
    private $name;
    private $description;
    private $price;
    private $stock;

    public function getProductID() {
        return $this->productID;
    }
    public function setProductID($productID) {
        $this->productID = $productID;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPrice() {
        return $this->price;
    }
    public function setPrice($price) {
        $this->price = $price;
    }

    public function getStock() {
        return $this->stock;
    }
    public function setStock($stock) {
        $this->stock = $stock;
    }
}
?>
