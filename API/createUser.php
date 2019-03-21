<?php
include_once("../lib/DatabasePDO.php");
include_once("../lib/User.php");

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

$userName = $_POST['userName'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$role = $_POST['role'];
$hash = password_hash($password1, PASSWORD_DEFAULT);

//TODO: this line of code should create a new user
// private $user = new User($userName, $firstName, $lastName, $hash, $role);


$user = [
    'userName' => $userName,
    'firstName' => $firstName,
    'lastName' => $lastName,
    'hash' => $hash,
    'role' => $role,
    'deleted' => '0'
]; 

$query = "INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `role`, `password`,`deleted`) 
            VALUES (:userName, :firstName, :lastName, :role, :hash, :deleted);";


//TODO: This query should extract the parameters from the user and send it to the database. Does not function properly yet
/*
$query = "INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `role`, `password`,`deleted`) 
            VALUES ($user->getUserName();, $user->getFirstName();, $user->getLastName();, $user->getRole();, $user->getHash();, $user->getDeleted(););";
*/

try {
    $statement = $conn->prepare($query);
    $statement->execute($user);

   echo 'De nieuwe gebruiker is aangemaakt';
   header('Refresh: 1; URL = ../userListOverview.php');
} catch (PDOException $e){
    echo "Error: {$e->getMessage()}";
    
}
?>
