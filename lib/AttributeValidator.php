<?php
include 'UserDAO.php';

class AttributeValidator {

/*-----------------------------------user name validaton---------------------------------*/
    public function validateUserName($userName) {
        $error = "";
        $userDAO = new UserDAO();
        $existingUser = $userDAO->findUser($userName);

        if (empty($userName)){
            $error = "Gebruikersnaam is vereist.";
        }
        elseif (!preg_match("/^[a-zA-Z ]*$/",$userName)) {
            $error = "Alleen letters en spaties zijn toegestaan.";
        }
        elseif(!$this->checkLength($userName,5)){
            $error="Gebruikersnaam moet minstens uit 5 karakters bestaan.";
        }
        elseif($existingUser!=="[]"){
            $error = "De gebruikersnaam is reeds geregistreerd.";
        }
        $userNameAndError = array($userName, $error);
        return $userNameAndError;
    }


/*-----------------------------------first name validaton---------------------------------*/
    public function validateFirstName($firstName) {
        $error = "";
        $firstNameTested = $this->test_input($firstName);

        if (empty($firstName)){
            $error = "Voornaam is vereist.";
        }
        elseif (!$this->checkLength($firstName,2)) {
            $error = "Voornaam moet uit ten minste 2 karakters bestaan.";
        }
        elseif ($firstNameTested !== $firstName){
            $error = "De voornaam heeft ongelige karakters.";
        }
        $firstNameAndError = array($firstName, $error);
        return $firstNameAndError;
    }

/*-----------------------------------last name validaton---------------------------------*/
    public function validateLastName($lastName) {
        $error = "";

        if (empty($lastName)){
            $error = "Achternaam is vereist";
        }
        elseif (!$this->checkLength($lastName,2)) {
            $error = "Achternaam moet uit ten minste 2 karakters bestaan.";
        }
        $lastNameAndError = array($lastName, $error);
        return $lastNameAndError;

    }

/*-----------------------------------email address validaton---------------------------------*/
    public function validateEmail($email) {
        $error = "";

        if (empty($email)){
            $error = "Email adres is vereist";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Ongeldig emailadres.";
        }
            $emailAndError = array($email, $error);
            return $emailAndError;
    }

/*-----------------------------------password validaton---------------------------------*/
    public function validatePassword($password1, $password2) {
        $error = "";

        if (empty($password1 or $password2)){
            $error = "Wachtwoord is vereist.";
        }
        elseif($password1!== $password2){
            $error="Wachtwoorden zijn niet gelijk";
        }
        elseif(!$this->checkPassword($password1)){ // checkPassword returns true if patern is fine if not it will return false
                                            // and !false will be true so will create error massage
            $error="Uw wachtwoord moet minimaal 8 tekens bevatten, waarvan tenminste 1 hoofdletter, 1 kleine letter en 1 cijfer.";
        }
            $passwordAndError = array($password1, $error);
            return $passwordAndError;
    }

/*-----------------------------helper functions-----------------------------------*/
    //this function length of the input  for firstname,lastname or whereever required
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //this function length of the input  for firstname,lastname or wherever required
    public function checkLength($str, $len){
        return strlen($str) >= $len;
    }

    // check pasword with regex  due to requirements
    public function checkPassword($password){
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password);
    }
}

?>
