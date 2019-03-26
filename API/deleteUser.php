<?php 

 include_once("../lib/UserDAO.php");
$userName=$_GET['userName'];
             //echo $userName; 


    $userDAO= new UserDAO();
    $userDAO->deleteUser($userName);



    
    
    ?>


