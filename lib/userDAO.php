<?php
include 'DAO.php';

class userDAO extends DAO {
    
    public function storeInDB ($user){
        $userName = $user->getUserName();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        $role = $user->getRole();
        $hash = $user->getHash();
        $deleted = $user->getDeleted();
        
        $query ="INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `email`,`role`, `password`,`deleted`) 
            VALUES '$userName', '$firstName', '$lastName', '$email', '$role', '$hash', '$deleted'";
            
        parent::SendQueryToDB($query);
    }
}
?>