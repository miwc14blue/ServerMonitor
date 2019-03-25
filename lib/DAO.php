<?php

include_once("DatabasePDO.php");

class DAO {
    
    public function SendQueryToDB($data){
        $query = $data;   
        var_dump($query);
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