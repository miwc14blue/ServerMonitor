<?php
class UserValidator {
        
    public function validateUsername($userName) {  
        if (preg_match('/[^a-zA-Z]/', $userName)){
        echo 'only letters are allowed';
        }
        return $userName;
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
}

?>
