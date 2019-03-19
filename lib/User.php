<?php
class User {
    
    private $userName;
    private $firstName;
    private $lastName;
    private $role;
    private $hash;
    private $deleted;
    
    public function createUser($userName, $firstName, $lastName, $hash) {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->hash = $hash;
        $this->role = "user";
        $this->deleted = "0";
        }
    }
?>
