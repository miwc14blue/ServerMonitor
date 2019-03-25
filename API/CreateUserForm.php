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
        $userNameErr = $firstNameErr=$lastNameErr=$emailErr=$passwordErr=$roleErr  = "";
        $userName = $firstName=$lastName=$email = $password1=$password2=$role=$password= "";
        
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
            
        //Checks role from input field for validity
            $roleAndErrMessage = $attributeValidator->validateRole($_POST["role"]);
            $role = $roleAndErrMessage[0];
            $roleErr = $roleAndErrMessage[1];
            
            
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
       
       
        <h1>Nieuwe gebruiker aanmaken</h1>
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

