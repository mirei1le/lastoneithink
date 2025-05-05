<?php
class Transaction {
    private $transactionID;
    private $userID;
    private $productID;
    private $quantity;
    private $total_price;
    private $paymentMethod;
    private $transactionDate;
    private $status;

    public function getTransactionID() {
        return $this->transactionID;
    }
    public function setTransactionID($transactionID) {
        $this->transactionID = $transactionID;
    }

    public function getUserID() {
        return $this->userID;
    }
    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getProductID() {
        return $this->productID;
    }
    public function setProductID($productID) {
        $this->productID = $productID;
    }

    public function getQuantity() {
        return $this->quantity;
    }
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getTotalPrice() {
        return $this->total_price;
    }
    public function setTotalPrice($total_price) {
        $this->total_price = $total_price;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }
    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function getTransactionDate() {
        return $this->transactionDate;
    }
    public function setTransactionDate($transactionDate) {
        $this->transactionDate = $transactionDate;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
}
?>
