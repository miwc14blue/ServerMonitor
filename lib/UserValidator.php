<?php
class UserValidator {
        
/*-----------------------------------user name validaton---------------------------------*/
    public function validateUserName($data) {  
        $error = "";
        $userName = $data;
        
        if (empty($userName)){
            $error = "Gebruikersnaam is vereist.";
        }
        elseif (!preg_match("/^[a-zA-Z ]*$/",$userName)) {
            $error = "Alleen letters en spaties zijn toegestaan.";
        }
        $userNameAndError = array($userName, $error);
        return $userNameAndError;
    } 
    
/*-----------------------------------first name validaton---------------------------------*/ 
    public function validateFirstName($data) {
        $error = "";
        $firstName = $data;
        $firstNameTested = test_input($firstName);
        
        if (empty($firstName)){
            $error = "Voornaam is vereist.";
        }
        elseif (!checkLength($firstName,2)) {
            $error = "Voornaam moet uit ten minste 2 karakters bestaan.";
        }
        elseif ($firstNameTested !== $firstName){
            $error = "De voornaam heeft ongelige karakters.";
        }
        $firstNameAndError = array($firstName, $error);
        return $firstNameAndError;
    }

/*-----------------------------------last name validaton---------------------------------*/
    public function validateLastName($data) {
        $error = "";
        $lastName = $data;
        
        if (empty($lastName)){
            $error = "Achternaam is vereist";
        }
        elseif (!checkLength($lastName,2)) {
            $error = "Achternaam moet uit ten minste 2 karakters bestaan.";
        }
        $lastNameAndError = array($lastName, $error);
        return $lastNameAndError;
    }

/*-----------------------------------email address validaton---------------------------------*/      
    public function validateEmail($data) {
        $error = "";
        $email = $data;
        
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
    public function validatePassword($data1, $data2) {
        $error = "";
        $password1 = $data1;
        $password2 = $data2;
        
        if (empty($password1 or $password2)){
            $error = "Wachtwoord is vereist.";
        } 
        elseif($password1!== $password2){
            $error="Wachtwoorden zijn niet gelijk";
        }
        elseif(!checkPassword($password1)){ // checkPassword returns true if patern is fine if not it will return false
                                            // and !false will be true so will create error massage
            $error="Het wachtwoord moet bestaan uit (minimaal) 8 tekens, waarvan (minimaal) 1 hoofdletter, 1 kleine letter en 1 nummer.";
        }
            $passwordAndError = array($password1, $error);
            return $passwordAndError;
    }
    
/*-----------------------------------role validaton---------------------------------*/ 
    public function validateRole($data) {
        $error = "";
        $role = $data;
        
        if (empty($role)){
            $error = "Rol is vereist.";
        }
        $roleAndError = array($role, $error);
        return $roleAndError;
    }

/*-----------------------------helper functions-----------------------------------*/    
    //this function length of the input  for firstname,lastname or whereever required
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    //this function length of the input  for firstname,lastname or whereever required
    function checkLength($str, $len){
        return strlen($str) >= $len;
    }

    // check pasword with regex  due to requirements
    function checkPassword($password){
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password);
    }
}

?>
