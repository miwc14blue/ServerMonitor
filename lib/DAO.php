<?php

include_once("DatabasePDO.php");

class DAO {
    
    public function SendQueryToDB($query){
        $databasePDOInstance = new DatabasePDO();
        $conn = $databasePDOInstance->get();
        
        try{
            $statement = $conn->prepare($query);
            $statement->execute();
        
        } catch (DPOException $e){
            echo "Error: {$e->getMessage()}";
        }
        return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
    }    
}
?>