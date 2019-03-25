<?php
class User {
    
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $role;
    private $hash;
    private $deleted;
    
    //constructor
    public function __construct($userName, $firstName, $lastName, $email, $hash, $role) {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->hash = $hash;
        $this->role = $role;
        $this->deleted = "0";
    }
    
    
    public function getUserName() {
        return $this->userName;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getRole() {
        return $this->role;
    }
    
    public function getHash() {
        return $this->hash;
    }

    public function getDeleted() {
        return $this->deleted;
    }
}
?>
