<?php
class User {
    
    private $id
    private $userName;
    private $firstName;
    private $lastName;
    private $role;
    private $password;
    private $deleted;
    
    public function createUser() {
        $user = 
        $dsn = "{$this->driver}:dbname={$this->schema};port=3307;host={$this->host}";
        
        try {
            $conn = new PDO($dsn, $this->username, $this->password);
            return $conn;
            
        } catch (PDOException $e) {
            echo "connection failed: {$e->getMessage()}";
        }
    }
}

?>