<?php

include_once('DatabasePDO.php');

class Query
{

  private $conn;
  private $databaseType;

  public function __construct()
  {
    $databasePDOInstance = new DatabasePDO();
    $this->conn = $databasePDOInstance->get();
    $this->databaseType = $databasePDOInstance->getDatabaseType();
  }

  public function queryUserByUserName($userName)
  {

    switch ($this->databaseType) {
      case 'mysql':
        $query = "SELECT * FROM user WHERE userName='$userName'";
      case 'couchDB':
    }

    $row = $this->fetchObject($query);
    var_dump($row['userName']);
    die;
    $user = new User($row['userName'], $row['firstName'], $row['lastName'], $row['role'], $row['password'], $row['deleted']);
    return $user;
  }

  public function fetchObject($query)
  {
    try {
      $statement = $this->conn->prepare($query);
      $statement->execute();
      //    echo json_encode($statement->fetchObject());
    } catch (DPOException $e) {
      echo "Error: {$e->getMessage()}";
    }
    if ($statement->rowCount() === 1) {
      return $statement->fetch(PDO::FETCH_ASSOC);
    }
  }
}
 ?>

 