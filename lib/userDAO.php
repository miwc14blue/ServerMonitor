<?php
class userDAO extends DAO {
    
    include_once("../lib/DatabasePDO.php");
    
    
    public function storeInDB ($user){
        
        $query = "INSERT INTO servermonitor.user (`userName`, `firstName`, `lastName`, `rolre`, `password`,`deleted`) 
            VALUES ("$user->getName()", " $user->getFirstName", " $user->getLastName", " $user->getRole", " 
            $user->getHash", " $user->getDeleted)";"
            
        parent::SendQueryToDB($query);
    }
}
?>