<DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Nieuwe gebruiker</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-makeUserForm.css">
    </head>

    <body>
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
    $nameErr = "userName is required";
  } else {
    $userName = test_input($_POST["userName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["firstName"])) {
    $firstNameErr = "firstName is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
     
  }


  if (empty($_POST["lastName"])) {
    $lastNameErr = "lastName is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    
    
  }

  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
    
  if(empty($_POST["password1"])){
    $password1Error="Password is required...!";

}else{
$password1=test_input($_POST["password1"]);
    
}

if(empty($_POST["password2"])){
    $password2Err="Confirm password  is required...!";
  
} elseif ($password1!=$password2){
    $password2Err="Passwords do not match.";        
    }else{
    $password2 = test_input($_POST["password2"]);
}

  if (empty($_POST["role"])) {
    $roleErr = "role is required";
  } else {
    $role = test_input($_POST["role"]);
  }
}

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
        
        
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
    
?>

        <h1>Nieuwe gebruiker aanmaken</h1>

        <form method="POST" action="../API/makeUserForm.php">
            <div>
                <p>
                    <label>Gebruikersnaam</label>
                    <input name='userName' type="text" value="<?php echo $userName;?>" />
                    <span><?php echo $userNameErr;?></span>
                </p>
                <p>
                    <label>Emailadres</label>
                    <input name='email' type="text" value="<?php echo $email;?>" />
                    <span><?php echo $emailErr;?></span>
                </p>
                <p>
                    <label>Voornaam</label>
                    <input name='firstName' type="text" value="<?php echo $firstName;?>" />
                    <span><?php echo $firstNameErr;?></span>
                </p>
                <p>
                    <label>Achternaam</label>
                    <input name='lastName' type="text" value="<?php echo $lastName;?>" />
                    <span><?php echo $lastNameErr;?></span>
                </p>
                <br>
                <p>
                    <label>Wachtwoord</label>
                    <input name='password1' type="text" value="<?php echo $password1;?>" />
                    <span><?php echo $password1Err;?></span>
                </p>
                <p>
                    <label>Herhaal wachtwoord</label>
                    <input name='password2' type="text" value="<?php echo $password2;?>" />
                    <span><?php echo $password2Err;?></span>
                </p>
            </div>
            <div class="buttonsFromForm">

                <div class="radioButton"><input name='role' type="radio" value="admin" /> Administrator</div>
                <div class="radioButton"><input name='role' type="radio" value="user" /> Gebruiker</div>

                <div>
                    <input type="submit" value="Maak gebruiker aan" id="submitButton" />
                    <button type="reset" value="Reset" id="resetButton">Reset</button>
                </div>
            </div>
        </form>
        <button id="cancelbutton" onclick="location.href=`userListOverview.php`"> Annuleren</button>

    </body>

    </html>
</DOCTYPE>
