<?php 

 include_once("../lib/UserDAO.php");
$userName=$_GET['userN'];
             echo $userName; 
    //      if(isset($_GET['userN'])){
    //         echo "postt klarr";
    //         $userName=$_GET['userN'];
    //         deleteUser($userName);

    // }

    $userDAO= new UserDAO();
    $userDAO->deleteUser($userName);



    
    
    ?>


