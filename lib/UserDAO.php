<?php
include 'DAO.php';
//include 'userListOverview.php';

//include_once("../html/userListOverview.php");


class UserDAO extends DAO {

        
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
    
    
    public function findUser($userName){ 
        $query = "SELECT * from user where userName= '$userName';";
        $user = parent::SendQueryToDB($query);
        return $user;
    }


    
    public function deleteUser($userName){

    
        $deletionQuery="UPDATE user SET deleted =1 WHERE userName='$userName';";
        $user = parent::SendQueryToDB($deletionQuery);


         header("Location:../html/userListOverview.php");
      
     //return header('../html/userListOverview.php');
        
        //retrieveUserList();



    }

    
    public function retrieveUserList() {
        $query = "SELECT userName, firstName, lastName, role 
        FROM servermonitor.user  
        WHERE (`deleted` = '0') ORDER BY userName;";

        $userList = parent::SendQueryToDB($query);
        return $userList;
    }
}
?>