<?php
session_start();

if(!isset($_SESSION['username']) || !($_SESSION['role']=='admin')){
   header("Location:../login.php");
}

?>

<!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8">
        <title>Gebruiker maken/aanpassen</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-updateUserForm.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    </head>
    <body>
      <?php
            include_once("../lib/AttributeValidator.php");
            include_once("../lib/User.php");
            include_once("../lib/UserDAO.php");
            require_once('menu.php');

        // define variables and set to empty values
        $userNameErr = $firstNameErr=$lastNameErr=$emailErr=$passwordErr=$roleErr = "";
        $userName = $firstName=$lastName=$email = $password1=$password2=$role=$password = "";
        $userDAO = new UserDAO();
        $state = "aanmaken";
            
/*---------------------------------------clears password error if user exist and no password filled in----------------------------------*/       
        
        
        
        if (!empty($_GET["userName"])) { 
            $userName = $_GET["userName"];
            $firstName = $_GET["firstName"];
            $lastName = $_GET["lastName"];
            $email = $_GET["email"];
            $role = $_GET["role"];
            setPageState($userName);
        } 
        
        elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $saveWithHash = true;
            $attributeValidator = new AttributeValidator();            

        //Checks user name from input field for validity
            $userNameAndErrMessage = $attributeValidator->validateUserName($_POST["userName"]);
            $userName = $userNameAndErrMessage[0];
            $userNameErr = $userNameAndErrMessage[1];
            $state = setPageState($userName);

        //Checks first name from input field for validity
            $firstNameAndErrMessage = $attributeValidator->validateFirstName($_POST["firstName"]);
            $firstName = $firstNameAndErrMessage[0];
            $firstNameErr = $firstNameAndErrMessage[1];

        //Checks last name from input field for validity
            $lastNameAndErrMessage = $attributeValidator->validateLastName($_POST["lastName"]);
            $lastName = $lastNameAndErrMessage[0];
            $lastNameErr = $lastNameAndErrMessage[1];

        //Checks e-mail address from input field for validity
            $emailAndErrMessage = $attributeValidator->validateEmail($_POST["email"]);
            $email = $emailAndErrMessage[0];
            $emailErr = $emailAndErrMessage[1];

        //Checks passwords from input field for validity
            $passwordAndErrMessage = $attributeValidator->validatePassword($_POST["password1"], $_POST["password2"]);
            $password = $passwordAndErrMessage[0];
            $passwordErr = $passwordAndErrMessage[1];
            
            
/*---------------------------------------clears password error if user exist and no password filled in----------------------------------*/
            $saveWithHash = omittingPasswordForExistingUser($passwordErr, $userNameErr);
            
            if (!$saveWithHash) {
                $passwordErr= "";
            }            
            
/*-------------------------------------user name overwrite checks for password and user existence-------------------------------------------*/
            
            $saveWithHash = overwiteExistingUser($userNameErr, $password);
            
/*---------------------------------------if no errors, make user and send to DB--------------------------------------------------*/
            storeUserIfGoodToGo($userNameErr, $firstNameErr, $lastNameErr, $emailErr, $passwordErr, 
                                $password, $userName, $firstName, $lastName, $email, $role, $saveWithHash);

        } 
        
         
        
////////////////////////////////////////////////////////FUNCTIONS////////////////////////////////////////////////////////////////////     
        
/*---------------------------------------if no errors, make user and send to DB----------------------------------------------------------*/
        function storeUserIfGoodToGo($userNameErr, $firstNameErr, $lastNameErr, $emailErr, $passwordErr, $password, $userName, $firstName, $lastName, $email, $role, $saveWithHash) {
            
            //Creates record with password.
            if (empty($userNameErr) and empty($firstNameErr) and empty($lastNameErr) 
                    and empty($emailErr) and empty($passwordErr)){                    
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $user = new User($userName, $firstName, $lastName, $email, $hash, $role);
                    $userDAO->storeInDB($user);
                    header("Location: ../html/userListOverview");
                }
            
            //Updates record without password.
            elseif ($userNameErr === "De gebruikersnaam is reeds geregistreerd." and empty($firstNameErr) 
                    and empty($lastNameErr) and empty($emailErr) and empty($password) and !$saveWithHash){
                echo '<script>popup()</script>';
                $user = new User($userName, $firstName, $lastName, $email, "dummyHash", $role);
                $userDAO->updateInDBWithoutHash($user);
                header("Location: ../html/userListOverview");
            }
            ////Updates record with password.
            elseif (empty($firstNameErr) and empty($lastNameErr) and empty($emailErr) and empty($passwordErr) 
                    and ($userNameErr === "De gebruikersnaam is reeds geregistreerd.")){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User($userName, $firstName, $lastName, $email, $hash, $role);
                $userDAO->updateInDBWithHash($user);
                header("Location: ../html/userListOverview");
            }
        }
        
/*--------------------------------------- user name overwrite checks for password and user existence-----------------------------------*/
        function overwiteExistingUser($userNameErr, $password){
            if ($userNameErr === "De gebruikersnaam is reeds geregistreerd.") {
                $saveWithHash = false;
            if(!empty($password)){
                $saveWithHash = true;
                }
            }
            else {$saveWithHash = true;
                 }
            return $saveWithHash;
            }

/*--------------------------------------- allows empty password fields for existing users-----------------------------------*/
        function omittingPasswordForExistingUser($passwordErr, $userNameErr){
         if ($passwordErr === "Wachtwoord is vereist." and $userNameErr === "De gebruikersnaam is reeds geregistreerd.") {
                $saveWithHash = false;
                }
            else {
                $saveWithHash = true;
            }
            return $saveWithHash;
            }

/*--------------------------------------- checks user existence and changes page state accordingly-----------------------------------*/
        function setPageState($userName) {
            $userDAO = new UserDAO();
            if (empty($userDAO->findUser($userName))){
                $state = "aanmaken";
            }
            else {
                $state = "bewerken";
            }
        }
/////////////////////////////////////////////////////////Form starts here////////////////////////////////////////////////////////////////////   
    
      ?>

      <div class="page">
        <div class="wrapper">
          <div class="header-container">
            <h2>Gebruiker <?php echo $state ?></h2>
          </div>
          <form method="POST" action="userManipulation.php">
              <div id="containerLinks">
                  <p>
                      <label>Gebruikersnaam
                          <span class="error">* <?php echo $userNameErr;?></span>
                          <input name='userName' type="text" value="<?php echo $userName;?>" class="input-field"/>
                      </label>
                  </p>
                  <p>
                      <label>Wachtwoord
                          <span class="error">* <?php echo $passwordErr;?> </span>
                          <input name='password1' type="text" value="<?php echo $password1;?>" class="input-field"/>
                      </label>
                  </p>
                  <p>
                      <label>Voornaam
                          <span class="error">* <?php echo $firstNameErr;?></span>
                          <input name='firstName' type="text" value="<?php echo $firstName;?>" class="input-field"/>
                      </label>
                  </p>
                  <p>
                      <label>Rol
                          <span class="error"></span>
                          <select name="role">
                              <option value="User"  selected>User</option>
<!--           TODO: pre-seleced value user does not show on screen-->                              
                              <option value="Administrator">Administrator</option>
                          </select>
                      </label>
                  </p>
              </div>

              <div id="containerRechts">
                  <p>
                      <label>hidden
                        <input class="input-field"/>
                      </label>
                  </p>

                  <p>
                      <label>Herhaal wachtwoord
                        <span class="error">* <?php echo $passwordErr;?></span>
                        <input name='password2' type="text" value="<?php echo $password2;?>" class="input-field"/>
                      </label>
                  </p>
                  <p>
                      <label>Achternaam
                        <span class="error">* <?php echo $lastNameErr;?></span>
                        <input name='lastName' type="text" value="<?php echo $lastName;?>" class="input-field" />
                      </label>
                  </p>
                  <p>
                      <label>Email-adres
                        <span class="error">* <?php echo $emailErr;?></span>
                        <input name='email' type="text" value="<?php echo $email;?>" class="input-field" />
                      </label>
                  </p>
              </div>

              <div class="zend">
                <a class="btn" href="userListOverview.php">Annuleren</a>
                <?php if($state=='bewerken'){ ?>
                
<!--           TODO: delete button still has to be implemented.-->
                <a class="btn btn-verwijderen" href="">Gebruiker verwijderen</a>
                <?php } ?>
                <input class="btn btn-opslaan" id="submitButton" type="submit" value="Gebruiker <?php echo $state ?>" />
                <button class="btnSize hoverColor" id="resetButton" type="reset" value="Reset">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </body>

    </html>
