<?php
class DatabasePDO {

    
    private $schema = 'servermonitor';
    private $driver = 'mysql';
    private $username = 'root';
    private $password = 'root'; 
    
    private $host = '127.0.0.1'; 
    private $port = '3307';
    //voor Arend:
    // private $host = '192.168.64.2';
    // private $port = '3306';
  
    
    
    
    public function get() {
        // $dsn = "{$this->driver}:dbname={$this->schema};port=3307;host={$this->host}";
        //voor Arend:
        $dsn = "{$this->driver}:dbname={$this->schema};port={$this->port};host={$this->host}";

        try {
            $conn = new PDO($dsn, $this->username, $this->password);
            return $conn;

        } catch (PDOException $e) {
            echo "connection failed: {$e->getMessage()}";
        }
    }
}

?>
