<?php
class Review {
    private $reviewID;
    private $userID;
    private $productID;
    private $rating;
    private $reviewText;
    private $reviewDate;

    public function getReviewID() {
        return $this->reviewID;
    }
    public function setReviewID($reviewID) {
        $this->reviewID = $reviewID;
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

    public function getRating() {
        return $this->rating;
    }
    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getReviewText() {
        return $this->reviewText;
    }
    public function setReviewText($reviewText) {
        $this->reviewText = $reviewText;
    }

    public function getReviewDate() {
        return $this->reviewDate;
    }
    public function setReviewDate($reviewDate) {
        $this->reviewDate = $reviewDate;
    }
}
?>
