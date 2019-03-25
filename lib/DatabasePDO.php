<?php
class DatabasePDO
{


    private $schema = 'servermonitor';
    private $driver = 'mysql';
    private $username = 'root';
    private $password = '';

    private $host = '127.0.0.1';
    private $port = '3307';

    private $passwordMac = '';
    private $hostMac = '192.168.64.2';
    private $portMac = '3306';




    public function get()
    {

        if (PHP_OS_FAMILY == 'Linux') {

            $dsn = "{$this->driver}:dbname={$this->schema};port={$this->portMac};host={$this->hostMac}";

            try {
                $conn = new PDO($dsn, $this->username, $this->passwordMac);
                return $conn;
            } catch (PDOException $e) {
                echo "connection failed: {$e->getMessage()}";
            }
        } else {

            $dsn = "{$this->driver}:dbname={$this->schema};port={$this->port};host={$this->host}";

            try {
                $conn = new PDO($dsn, $this->username, $this->password);
                return $conn;
            } catch (PDOException $e) {
                echo "connection failed: {$e->getMessage()}";
            }
        }
    }
}

 