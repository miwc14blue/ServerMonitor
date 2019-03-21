<?php
session_start();
if((!isset($_SESSION['username'])) || !($_SESSION['role']=='admin')){
   header("Location:../login.php");
}

// if($_SESSION['role']=='user'){
//   header("Location:../login.php");
// }
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Gebruikers Overzicht</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../css/styles-landingpages.css">
    </head>
    <body>

    <nav id="navHeader">
        <img class="logo" src="../img/logo.png">


        <a class= "active" href="systeemOverzichtAdm.php" >Systeem overzicht</a>
        <a href="../userListOverview.php" >Gebruikers</a>
        <a class= "uitloggen" href="../logout.php" >Uitloggen</a>
    </nav>

        <div id="container">
        <h3 id="h3">Systeem overzicht</h3>
        </div>

    </body>
</html>
