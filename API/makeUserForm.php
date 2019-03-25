<DOCTYPE html>
    <html>

    <head>
        <style>
          .error {color: #FF0000;}
        </style>
        <meta charset="utf-8">
        <title>Nieuwe gebruiker</title>
    </head>

    <body>
<?php
// define variables and set to empty values
$userNameErr = $firstNameErr=$lastNameErr=$emailErr = $password1Err=$password2Err=$roleErr  = "";
$userName = $firstName=$lastName=$email = $password1=$password2=$role  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Username (Required, Unique, minimum 5 characters)
  if (empty($_POST["userName"])) {
  $userNameErr = "userName is required";

  }else {
    $userName = test_input($_POST["userName"]);
    
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$userName)) {
      $userNameErr = "Only letters and white space allowed"; 
    }
  }

  
if(!checkLength($userName,5)){
    $userNameErr="userName should be 5 characters";

  }
  
  ///First Name (Required, minimum of 2 characters) , first if foerrequired second if for at least 2 caharacers
  if (empty($_POST["firstName"])) {
    $firstNameErr = "firstName is required";
  } 
  else {
    $firstName = test_input($_POST["firstName"]);
     if(!checkLength($firstName,2)){
     $firstNameErr = "firstName should be at least 2 characters";
  }

}

//Surname (Required, minimum of 2 characters) ,first if for required second if for at least 2 caharacers

if (empty($_POST["lastName"])) {
    $lastNameErr = "lastName is required";
  }else {
    $lastName = test_input($_POST["lastName"]);
 
    if(!checkLength($lastName,2)){
     $lastNameErr = "lastName should be at least 2 characters"; 
 }
    
  }

  //Email Address (Required, meets validation guidelines for email Link)
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  }else {
    $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     // check if e-mail address is well-formed
      $emailErr = "Invalid email format"; 
    } 
    
  }
  
  
    //Password (Required, at least 8 characters of which 1 uppercase letter, 1 lowercase letter and 1 number)

 if(empty($_POST["password1"])){
    $password1Err="Password  is required...!";
    }else{
      $password1=test_input($_POST["password1"]);
      if(!checkPassword($password1)){
          $password1Error="The password name must contain at least 8 characters
   of which 1 uppercase letter, 1 lowercase letter and 1 number'";
  //checkPassword returns true if patern is fine if not it will return false and 
  //!false will be true so will create error massage
}
       }
       
if(empty($_POST["password2"])){
    $password2Err="Confirm password  is required...!";
  
}else{
   $password2 = test_input($_POST["password2"]);
  if($password1!=$password2){
  $password2Err="paswords Not Match";

}
}

  if (empty($_POST["role"])) {
    $roleErr = "role is required";
  } else {
    $role = test_input($_POST["role"]);
  }
}

///this function length of the input  for firstname,lastname or whereever required
 function checkLength($str, $len){
    return strlen($str) >= $len;
  }
// checks pasword with regex  due to requirements
   function checkPassword($pass){
      return preg_match( "(?=.*?[0-9])", $pass);
  }


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



        <h1>Nieuwe gebruiker aanmaken</h1>
<p><span class="error">* required field</span></p>
        <form method="POST" action="makeUserForm.php">
            <p>
                <label>
                    Gebruikersnaam
                    <input name='userName' type="text"  value="<?php echo $userName;?>" />
                    <span  class="error">* <?php echo $userNameErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Voornaam
                    <input name='firstName' type="text" value="<?php echo $firstName;?>"/>
                    <span class="error">* <?php echo $firstNameErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Achternaam
                    <input name='lastName' type="text" value="<?php echo $lastName;?>" />
                    <span class="error">* <?php echo $lastNameErr;?></span>
                </label>
            </p>
             <p>
                <label>
                    EmailAdress
                    <input name='email' type="text"  value="<?php echo $email;?>" />
                    <span  class="error">* <?php echo $emailErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Wachtwoord
                    <input name='password1' type="text" value="<?php echo $password1;?>"/>
                    <span class="error">* <?php echo $password1Err;?></span>
                </label>
            </p>
           
            <p>
                <label>
                    Herhaal wachtwoord
                    <input name='password2' type="text" value="<?php echo $password2;?>"/>
                    <span class="error">* <?php echo $password2Err;?></span>
                </label>
            </p>
            <label>
                <input name='role' type="radio" value="admin" /> Administrator
                <span class="error">* <?php echo $roleErr;?></span>
            </label>
            <label>
                <input name='role' type="radio" value="user" /> Gebruiker
                <span class="error">* <?php echo $roleErr;?></span>
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