 <?php
    
        include_once("../lib/DatabasePDO.php");
        include_once("../lib/User.php");

        $databasePDOInstance = new DatabasePDO();
        $conn = $databasePDOInstance->get();    
        
        // define variables and set to empty values
        $userNameErr = $firstNameErr=$lastNameErr=$emailErr = $password1Err=$password2Err=$roleErr  = "";
        $userName = $firstName=$lastName=$email = $password1=$password2=$role  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Username (Required, Unique, minimum 5 characters)
  if (empty($_POST["userName"])) {
    $userNameErr = "Gebruikersnaam is vereist.";
  } else {
    $userName = test_input($_POST["userName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$userName)) {
      $userNameErr = "Alleen letters en spaties zijn toegestaan."; 
    }
  }

  ///First Name (Required, minimum of 2 characters) , first if foerrequired second if for at least 2 caharacers
  if (empty($_POST["firstName"])) {
    $firstNameErr = "Voornaam is vereist.";
  } elseif(!checkLength($firstName,2)){
     $firstNameErr = "Voornaam moet uit ten minste 2 karakters bestaan.";
  }
  else {
    $firstName = test_input($_POST["firstName"]);
     
  }

//Surname (Required, minimum of 2 characters) ,first if for required second if for at least 2 caharacers
  if (empty($_POST["lastName"])) {
    $lastNameErr = "Achternaam is vereist";
  }elseif(!checkLength($lastName,2)){
     $lastNameErr = "Achternaam moet uit ten minste 2 karakters bestaan."; 
  }
   
  else {
    $lastName = test_input($_POST["lastName"]);
    
    
  }

  //Email Address (Required, meets validation guidelines for email Link)
  if (empty($_POST["email"])) {
    $emailErr = "E-mailadres is vereist";
  }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     // check if e-mail address is well-formed
      $emailErr = "Ongeldig e-mail adres."; 
    } 
  else {
    $email = test_input($_POST["email"]);    
  }
    //Password (Required, at least 8 characters of which 1 uppercase letter, 1 lowercase letter and 1 number)
    if(empty($_POST["password1"])){
        $password1Err="Wachtwoord is vereist.";
    }
    elseif(!checkPassword($password1)){

  //checkPassword returns true if patern is fine if not it will return false and 
  //!false will be true so will create error massage
        $password1Error="Het wachtwoord moet bestaan uit (minimaal) 8 tekens, waarvan (minimaal) 1 hoofdletter, 1 kleine letter en 1 nummer.";
    } else{
        $password1=test_input($_POST["password1"]);
    }
    if(empty($_POST["password2"])){
        $password2Err="Wachtwoord bevestiging is vereist.";
    }elseif($password1!=$password2){
        $password2Err="Wachtwoorden zijn niet gelijk";
    }else{
   $password2 = test_input($_POST["password2"]);
    }
    if (empty($_POST["role"])) {
    $roleErr = "Rol is vereist.";
    } else {
    $role = test_input($_POST["role"]);
    }
}

///this function length of the input  for firstname,lastname or whereever required
 function checkLength($str, $len){
    return strlen($str) >= $len;
  }
// check pasword with regex  due to requirements
   function checkPassword($pass){
      return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $pass);
  }


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

        $user = ['userName' => $userName,
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