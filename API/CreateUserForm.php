<!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-makeUserForm.css">
        <meta charset="utf-8">
        <title>Nieuwe gebruiker</title>
    </head>

    <body>
        <?php
        include_once("../lib/AttributeValidator.php");
        include_once("../lib/User.php");
        include_once("../lib/UserDAO.php");

        // define variables and set to empty values
        $userNameErr = $firstNameErr=$lastNameErr=$emailErr=$passwordErr=$roleErr = "";
        $userName = $firstName=$lastName=$email = $password1=$password2=$role=$password = "";
        
        
        if (!empty($_GET["userName"])) { 
            $userName = $_GET["userName"];
            $firstName = $_GET["firstName"];
            $lastName = $_GET["lastName"];
            $email = $_GET["email"];
            $role = $_GET["role"];
        } 
        
        elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $saveWithHash = true;
            $attributeValidator = new AttributeValidator(); 
            

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $attributeValidator = new AttributeValidator();

        //Checks user name from input field for validity
            $userNameAndErrMessage = $attributeValidator->validateUserName($_POST["userName"]);
            $userName = $userNameAndErrMessage[0];
            $userNameErr = $userNameAndErrMessage[1];

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
            $userDAO = new UserDAO();
            
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
        
        function omittingPasswordForExistingUser($passwordErr, $userNameErr){
         if ($passwordErr === "Wachtwoord is vereist." and $userNameErr === "De gebruikersnaam is reeds geregistreerd.") {
                $saveWithHash = false;
                }
            else {
                $saveWithHash = true;
            }
            return $saveWithHash;
            }
        
/////////////////////////////////////////////////////////Form starts here////////////////////////////////////////////////////////////////////   
        ?>
       
       
        <h1>Nieuwe gebruiker aanmaken</h1>

/*---------------------------if no errors, make user and send to DB......................*/
            if (empty($userNameErr) and empty($firstNameErr) and empty($lastNameErr)
                and empty($emailErr) and empty($passwordErr)){

                $hash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User($userName, $firstName, $lastName, $email, $hash, $role);

                $userDAO = new UserDAO();
                $userDAO->storeInDB($user);
            }
        }
?>


        <p><span class="error">* required field</span></p>
        <form method="POST" action="CreateUserForm.php">
            <p>
                   <label>
                    Gebruikersnaam
                    <input name='userName' type="text" value="<?php echo $userName;?>" />
                    <span class="error">* <?php echo $userNameErr;?></span>
                    </label>
            </p>
            <p>
                    <label>
                    Voornaam
                    <input name='firstName' type="text" value="<?php echo $firstName;?>" />
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
                    Email
                    <input name='email' type="text" value="<?php echo $email;?>" />
                    <span class="error">* <?php echo $emailErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Wachtwoord
                    <input name='password1' type="text" value="<?php echo $password1;?>" />
                    <span class="error">* <?php echo $passwordErr;?></span>
                </label>
            </p>
            <p>
                <label>
                    Herhaal wachtwoord
                    <input name='password2' type="text" value="<?php echo $password2;?>" />
                    <span class="error">* <?php echo $passwordErr;?></span>
                </label>
            </p>
            <label>
                <!-- <input name='role' type="radio" value="admin" /> Administrator -->
                <div class="dropdown">
                    <button onclick="showContent()" class="btnSize hoverColor ">Rol</button>
                        <div id="myDropdown" class="dropdown-content">
                            <input class="radiobtn" name='role' type="radio" value="user" />User
                            <input class="radiobtn" name='role' type="radio" value="admin" />Admin
                        </div>
                </div>
                <span class="error">* <?php echo $roleErr;?></span>
            </label>
            <label>
                <input name='role' type="radio" value="user" checked="checked"/> Gebruiker
                <span class="error">* <?php echo $roleErr;?></span>
            </label>
            <p>
                <input class="btnSize hoverColor" id="submitButton" type="submit" value="Maak gebruiker aan" />
                <button class="btnSize hoverColor" id="resetButton" type="reset" value="Reset">Reset</button>

            </p>
        </form>
        <button class="btnSize hoverColor" id="cancelbutton" onclick="location.href=`userListOverview.php`"> Annuleren</button>
        
        
    </body>

    </html>
