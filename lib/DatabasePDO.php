
<?php
class DatabasePDO
{


    private $schema = 'servermonitor';
    private $driver = 'mysql';
    private $username = 'root';
    private $password = 'root';

    private $host = 'localhost';
    private $port = '8889';

    private $passwordMac = 'root';
    private $hostMac = 'localhost';
    private $portMac = '8889';




    public function get()
    {

        if (PHP_OS_FAMILY == 'Mac') {

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
