<?php
include_once("../lib/DatabasePDO.php");
include_once("../lib/User.php");

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

$userName =$firstName=$lastName= $email = $password1 = $password2 = $role = $hash="";
$userNameError =$firstNameError=$lastNameError= $emailError = $password1Error = $password2 = $role = $hash="";
$boolean =false;


$userName = $_POST['userName'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$role = $_POST['role'];
$hash = password_hash($password1, PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Username (Required, Unique, minimum 5 characters)
if(empty($_POST['userName'])){
    $userNameError="Username required...";
    $boolean=false;
}else{
    $userName = validate_input($_POST["userName"]);
    $boolean=true;

}
//Email Address (Required, meets validation guidelines for email Link)
if (empty($_POST['email'])) {

$emailError="Email required...!";
$boolean=false;
}elseif (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
    $emailError="Invalid Email";
    $boolean=false;
    
}else{
$email = validate_input($_POST["email"]);
$boolean=true;
}

//Password (Required, at least 8 characters of which 
//1 uppercase letter, 1 lowercase letter and 1 number)
$length=strLength($_POST["password1"]);

if(empty($_POST["password1"])){
    $password1Error="Password is required...!";
   $boolean=false;
}elseif ($length) {
    $password1Error=$length;
    $boolean=true;

 
}else{
    $password1 = validate_input($_POST["password1"]);
}

//pasowrd2-->confirm password

if(empty($_POST["password2"])){
    $password1Error="Confirm password  is required...!";
   $boolean=false;
}elseif ($_POST["password1"]!=$password1) {
    $password2Error="password Not Match...!";
    $boolean=false;

 
}else{
   $password2 = validate_input($_POST["password2"]);
}

//First Name (Required, minimum of 2 characters)
//Surname (Required, minimum of 2 characters)
$fnameLength=firstAndLastNameLength($_POST["firstName"]);
$lnameLength=firstAndLastNameLength($_POST["lastName"]);

if(empty($_POST["firstName"]) || empty($_POST["lastName"])){
    $firstNameError="FirstName is required";
    $lastNameError="lastname is required..!";
    $boolean=false;
}elseif ($fnameLength || $lnameLength) {
    $firstNameError=$fnameLength;
    $lastNameError=$lnameLength;
    
    $boolean=true;
}
else{
    $firstName = validate_input($_POST["firstName"]);
  $lastName = validate_input($_POST["lastName"]);
}
/////////////following 3 inputs are not covered yet ,I still working on it.
  $userName = validate_input($_POST["userName"]);
  $role = validate_input($_POST["role"]);
  $hash = validate_input($_POST["hash"]);
 ///////////////////////////////////////////// 
  //checks length of pasword
function strLength($str){
    $ln=strlen($str);
    if($ln<8){
        return "Password should at least   8 Characters" ;
    }
    return ;

}

function firstAndLastNameLength($name){
    $ln=strlen($name);
    if($ln<2){
        return "$name should  be at least   2 Characters" ;
    }
    return ;

}

  function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
}

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
} catch (PDOException $e){
    echo "Error: {$e->getMessage()}";
    
}
?>
