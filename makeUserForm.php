<DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Nieuwe gebruiker</title>
    </head>

    <body>
<?php
// define variables and set to empty values
$userNameErr = $firstNameErr=$lastNameErr=$emailErr = $password1Err=$password2Err=$roleErr  = "";
$userName = $firstName=$lastName=$emailErr = $password1=$password2=$role  = "";

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
  
}else{
   $password2 = test_input($_POST["password2"]);
}

  if (empty($_POST["role"])) {
    $roleErr = "role is required";
  } else {
    $role = test_input($_POST["role"]);
  }
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



        <h1>Nieuwe gebruiker aanmaken</h1>

        <form method="POST" action="API/createUser.php">
            <p>
                <label>
                    Gebruikersnaam
                    <input name='userName' type="text" />
                </label>
            </p>
            <p>
                <label>
                    Voornaam
                    <input name='firstName' type="text" />
                </label>
            </p>
            <p>
                <label>
                    Achternaam
                    <input name='lastName' type="text" />
                </label>
            </p>
            <p>
                <label>
                    Wachtwoord
                    <input name='password1' type="text" />
                </label>
            </p>
            <p>
                <label>
                    Herhaal wachtwoord
                    <input name='password2' type="text" />
                </label>
            </p>
            <label>
                <input name='role' type="radio" value="admin" /> Administrator
            </label>
            <label>
                <input name='role' type="radio" value="user" /> Gebruiker
            </label>
            <p>
                <input type="submit" value="Maak gebruiker aan" />
                <button type="reset" value="Reset">Reset</button>

            </p>
        </form>
        <button onclick="location.href=`userListOverview.php`">Annuleren</button>

    </body>

    </html>
</DOCTYPE>