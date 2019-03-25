<?php
class DatabasePDO {
    
    private $username = 'root';
    private $password = 'root';
    private $schema = 'servermonitor';
    private $driver = 'mysql';
    private $host = '127.0.0.1';
    
    public function get() {
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
 