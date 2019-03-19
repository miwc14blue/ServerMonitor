<?php
include_once("../lib/DatabasePDO.php");
// include_once("../lib/User.php");

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

// $userName = $_POST['userName'];
// $firstName = $_POST['firstName'];
// $lastName = $_POST['lastName'];
// $passWord = $_POST['password'];
// $hash = password_hash($password, PASSWORD_DEFAULT);


// $user = new User($userName, $firstName, $lastName, $hash);


$user = [
    'userName' => $_POST['userName'],
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName'],
    'hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'role' => 'user',
    'deleted' => '0'
]; 
$query = "INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `role`, `password`,`deleted`) 
            VALUES (:userName, :firstName, :lastName, :role, :hash, :deleted);";

try {
    $statement = $conn->prepare($query);
    $statement->execute($user);
} catch (PDOException $e){
    echo "Error: {$e->getMessage()}";
    
}
?>
