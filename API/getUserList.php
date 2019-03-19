<?php

include_once("../lib/DatabasePDO.php");

$databasePDOInstance = new DatabasePDO();

$conn = $databasePDOInstance->get();

$query = "SELECT userName, firstName, lastName, role FROM servermonitor.user  WHERE (`deleted` = '0') ORDER BY userName;";
    
    try{
        $statement = $conn->prepare($query);
        $statement->execute();
    
    } catch (DPOException $e){
        echo "Error: {$e->getMessage()}";
        }

echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));

?>
