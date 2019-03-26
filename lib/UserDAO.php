<?php
include 'DAO.php';
include("../API/CreateUserForm.php");

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
        $query = "SELECT * from user WHERE userName= '$userName';";
        $user = parent::SendQueryToDB($query);
        return $user;
    }

    public function createUserFromDB($userName) {
        $query = "SELECT * from user where userName= '$userName';";
        $userJSON = parent::SendQueryToDB($query);
        $data = json_decode($userJSON, true);
        $user = new User($data['userName'], $data['firstName'], $data['lastName'], $data['email'], $data['password'], $data['role']);
        $user->setDeleted($data['deleted']);
        var_dump($data);
        die;
        return $user;
    }

    public function loginInfo($userName){
        $query = "SELECT password, role, deleted from user where userName= '$userName';";
        $hashAndDelete = parent::SendQueryToDB($query);
        return $hashAndDelete;
    }
    
    public function retrieveUserList() {
        $query = "SELECT userName, firstName, lastName, role 
        FROM servermonitor.user  
        WHERE (`deleted` = '0') ORDER BY userName;";

        $userList = parent::SendQueryToDB($query);
        return $userList;
    }
    
    public function editUser($userName){
         $query = "SELECT userName, firstName, lastName, role 
        FROM servermonitor.user WHERE userName= '$userName';";
        $user = parent::SendQueryToDB($query);
        $editUserForm = new UserForm($user);
    }
}
?>