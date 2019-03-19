<?php

include_once("../lib/DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$query = "SELECT firstName, lastName, userName, role FROM servermonitor.user;";
    
    try{
        $statement = $conn->prepare($query);
        $statement = $conn->prepare($query);
        $statement->execute();
    
    } catch (DPOException $e){
        echo "Error: {$e->getMessage()}";
        }

echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));

?>