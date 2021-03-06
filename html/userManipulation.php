<?php
session_start();


if(!isset($_SESSION['username']) || !($_SESSION['role']=='admin')){
  header("Location:../login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gebruiker aanmaken/bewerken</title>
    <meta charset="utf-8">
    <title>Gebruiker <?php echo $state ?></title>
    <script type="text/javascript" src="../js/popup.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/styles-updateUserForm.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles-popup.css">
    <link rel="stylesheet" type="text/css" href="../css/styles-userlist.css">

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
        $state = "aanmaken";

/*---------------------------------------clears password error if user exist and no password filled in----------------------------------*/



        if (!empty($_GET["userName"])) {
            $userName = $_GET["userName"];
            $firstName = $_GET["firstName"];
            $lastName = $_GET["lastName"];
            $email = $_GET["email"];
            $role = $_GET["role"];
            $state = setPageState($userName);
        }

        elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $saveWithHash = true;
            $attributeValidator = new AttributeValidator();
            $state = setPageState($_POST["userName"]);

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

            $role = $_POST["role"];

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
            return $state;
        }
/////////////////////////////////////////////////////////Form starts here////////////////////////////////////////////////////////////////////

      ?>
    <div class="page">
        <div class="wrapper">
            <div class="header-container">
                <h2>Gebruiker <?php echo $state ?></h2>
            </div>
            <form method="POST" action="userManipulation.php">
                <div class="column-container">
                    <div class="column column-left">
                        <p>
                            <label>Gebruikersnaam
                                <span class="error">* <?php echo $userNameErr;?></span>
                                <input name='userName'<?php if ($state == "bewerken") echo ' disabled="disabled"';?> value="<?php echo $userName;?>" class="input-field"/>
                
                                <?php if ($state == "bewerken") echo '<input name="userName" type="hidden" value="'.$userName.'" class="input-field" />';?>
                            </label>
                        </p>
                        <p>
                            <label>Wachtwoord
                                <span class="error">* <?php echo $passwordErr;?> </span>
                                <input name='password1' type="text" value="<?php echo $password1;?>" class="input-field" />
                            </label>
                        </p>
                        <p>
                            <label>Voornaam
                                <span class="error">* <?php echo $firstNameErr;?></span>
                                <input name='firstName' type="text" value="<?php echo $firstName;?>" class="input-field" />
                            </label>
                        </p>
                        <p>
                            <label>Rol
                                <span class="error"></span>
                                <select name="role">
                                  <option value="user" <?php if($role=='user') { echo 'selected';}; ?>>User</option>
                                  <option value="admin" <?php if($role=='admin') { echo 'selected';}; ?>>Administrator</option>
                                </select>
                            </label>
                        </p>
                    </div>
                    <div class="column column-right">
                        <p>
                            <label>Herhaal wachtwoord
                                <span class="error">* <?php echo $passwordErr;?></span>
                                <input name='password2' type="text" value="<?php echo $password2;?>" class="input-field" />
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
                </div>
                <div class="zend">
                    <?php if($state=='aanmaken'){ ?>
                     <button class="btn btn-reset" type="reset" value="Reset">Reset</button>
                    <?php } ?>
                    <a class="btn" href="userListOverview.php">Annuleren</a>
                    <?php if($state=='bewerken'){ ?>
                    <a class="btn btn-verwijderen" onclick="show('<?php echo $userName ?>')">Gebruiker verwijderen</a>
                    <!--                    The Modal -->
                    <div id="myModal<?php echo $userName ?>" class="modal" onclick="hide('<?php echo $userName ?>')">
                        <!--                    Modal content -->
                        <div class="modal-content">

                            <div id="popup">
                                <span class="close" onclick="hide('<?php echo $userName ?>')">&times;</span>
                                <p id="popupTitle">Gebruiker verwijderen</p>
                                <p id="popupText">Weet u zeker dat u <?php echo $userName ?> wilt verwijderen?</p>
                            </div>
                            <div class="popupFooter">
                              <button class="btn" onclick="hide('<?php echo $userName ?>')">Annuleren</button>
                              <a class="btn btn-verwijderen" onclick="alert('<?php echo $userName;?> is verwijderd');window.location.href='../API/UserDelete.php? userName=<?php echo $userName?>';"><?php echo $userName?> verwijderen</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <input class="btn btn-opslaan" type="submit" value="Gebruiker <?php echo $state ?>" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
