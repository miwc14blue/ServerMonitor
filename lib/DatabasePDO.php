<?php
class DatabasePDO {
    
    private $username = 'root';
    private $password = ''; 
    // private $password = 'root'; 
    private $schema = 'servermonitor';
    private $driver = 'mysql';
    private $host = '127.0.0.1';
    // private $host = '192.168.64.2';
    
    public function get() {
        $dsn = "{$this->driver}:dbname={$this->schema};port=3307;host={$this->host}";
        // $dsn = "{$this->driver}:dbname={$this->schema};port=3306;host={$this->host}";
        try {
            $conn = new PDO($dsn, $this->username, $this->password);
            return $conn;
            
        } catch (PDOException $e) {
            echo "connection failed: {$e->getMessage()}";
        }
    }
}

?>
