<?php
class User
{

    private $userName;
    private $firstName;
    private $lastName;
    private $role;
    private $hash;
    private $deleted;

    public function __construct($userName, $firstName, $lastName, $role, $hash, $deleted)
    {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->hash = $hash;
        $this->deleted = $deleted;
    }
    public function setUserInfo($userName, $firstName, $lastName, $hash, $role, $deleted)
    {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hash = $hash;
        $this->role = $role;
        $this->deleted = $deleted;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function deleted()
    {
        return $this->deleted;
    }
}
 ?>
 