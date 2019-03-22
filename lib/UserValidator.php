<?php
class UserValidator {
        
    public function validateUserName($data) {  
        $errorCode = "";
        $userName = $data;
        
        if (empty($userName)){
            $errorCode = "Gebruikersnaam is vereist.";
        }
        elseif (!preg_match("/^[a-zA-Z ]*$/",$userName)) {
            $errorCode = "Alleen letters en spaties zijn toegestaan.";
        }
        $userNameAndErrCode = array($userName, $errorCode);
        return $userNameAndErrCode;
        }
    
    
    public function validateFirstName($firstName) {  
        return $firstName;
    }
    
    public function validateLastName($lastName) {  
        return $lastName;
    }
    
    public function validateEmailAddress($emailAddress) {  
        return $emailAddress;
    }    
    
    public function validatePassword($password1, $password2) {  
        return $password1;
    }
    
    public function validateRole($role) {  
    return $role;
    }
    
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    
    ///this function length of the input  for firstname,lastname or whereever required
    function checkLength($str, $len){
    return strlen($str) >= $len;
    }

    // check pasword with regex  due to requirements
    function checkPassword($pass){
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $pass);
    }
}

?>
