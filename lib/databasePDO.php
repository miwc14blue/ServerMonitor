<?php
class DatabasePDO {
  private $DB_SERVER = 'servermonitor';
  private $DB_USER = 'root';
  private $DB_PASSWORD = '';
  private $driver = 'mysql';
  private $host = '127.0.0.1:3307';

  public function get() {
    $dsn = "{$this->driver}:dbname={$this->DB_SERVER};host={$this->host}";

    try{
      $conn = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD);

      return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: {$e->getMessage()}";
    }
  }
}

?>
