<?php
class User {
    
    private $userName;
    private $firstName;
    private $lastName;
    private $role;
    private $hash;
    private $deleted;
    
    //constructor
    public function __construct($userName, $firstName, $lastName, $hash, $role) {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->hash = $hash;
        $this->role = $role;
        $this->deleted = "0";
        echo "User made";
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
    
    public function getrole() {
        return $this->role;
    }
    
    public function gethash() {
        return $this->hash;
    }

    public function getdeleted() {
        return $this->deleted;
    }
}
?>
