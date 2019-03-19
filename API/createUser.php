<?php
include_once("lib/DatabasePDO.php");
//include_once("lib/User.php");

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

    $userName => $_POST['userName'];
    $firstName => $_POST['firstName'];
    $lastName => $_POST['lastName']password_hash($password, PASSWORD_DEFAULT);,
    $passWord => $_POST['password'];
    $hash =>password_hash($password, PASSWORD_DEFAULT);
    $role => "user";
    $deleted => "0";

$user = new User('userName');
$data = [
    'userName' => $_POST['userName'],
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName']password_hash($password, PASSWORD_DEFAULT);,
    'passWord' => $hash $_POST['password'],
    'role' => 'user',
    'deleted' => '0'
];  
$query = "INSERT INTO orders (`userName`, `firstName`, `lastName`, `role`, `password`,`deleted`) 
            VALUES (:userName, :firstName, :lastName, :role, :password, :deleted);";

try {
    $statement = $conn->prepare($query);
    $statement->execute($data);
} catch (PDOException $e){
    echo "Error: {$e->getMessage()}";
    
}
?>


function addUser($name, $email, $password){
  $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?,?,?)";
  $this->stmt = $this->pdo->prepare($sql);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  return $this->stmt->execute([$name, $email, $hash]);
}

$pass = addUser("John Doe", "john@doe.com", "password123");
