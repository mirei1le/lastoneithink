<?php
class User {
    private $userID;
    private $fullName;
    private $email;
    private $password;
    private $dob;
    private $role;

    public function getUserID() {
        return $this->userID;
    }
    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getFullName() {
        return $this->fullName;
    }
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }

    public function getDob() {
        return $this->dob;
    }
    public function setDob($dob) {
        $this->dob = $dob;
    }

    public function getRole() {
        return $this->role;
    }
    public function setRole($role) {
        $this->role = $role;
    }
}
?>
