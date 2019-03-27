<?php 

 include_once("../lib/UserDAO.php");

   //   gets userName after clicking button  and assign it to the userNames
    $userName=$_GET['userName'];
    $userDAO= new UserDAO();
    $userDAO->deleteUser($userName);
    ?>


