<?php
class Orders {
    private $orderID;
    private $userID;
    private $totalPrice;
    private $orderStatus;

    public function getOrderID() {
        return $this->orderID;
    }
    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function getUserID() {
        return $this->userID;
    }
    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    public function getOrderStatus() {
        return $this->orderStatus;
    }
    public function setOrderStatus($orderStatus) {
        $this->orderStatus = $orderStatus;
    }
}
?>
