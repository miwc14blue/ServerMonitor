<?php
class DAO {
    
    include_once("../lib/DatabasePDO.php");
    
    
    public function SendQueryToDB ($query){
        $databasePDOInstance = new DatabasePDO();
        $conn = $databasePDOInstance->get();
        
        try{
            $statement = $conn->prepare($query);
            $statement->execute();
        
        } catch (DPOException $e){
            echo "Error: {$e->getMessage()}";
        }
    }
}
?>