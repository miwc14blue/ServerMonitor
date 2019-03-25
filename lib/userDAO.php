<?php
include 'DAO.php';

class userDAO extends DAO {
    
    public function storeInDB ($user){
        $userName = $user->getUserName();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        $hash = $user->getHash();
        $role = $user->getRole();
        $deleted = $user->getDeleted();
        
        $query = "INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `email`, `password`, `role`, `deleted`) 
            VALUES ('$userName', '$firstName', '$lastName', '$email', '$hash', '$role', '$deleted');";

        parent::SendQueryToDB($query);
    }
}
?>