<?php
session_start();
if((!isset($_SESSION['username'])) || !($_SESSION['role']=='admin')){
   header("Location:../login.php");
}
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

      <?php
          require_once('menu.php');
      ?>

        <div id="container">
        <h3 id="h3">Systeem overzicht</h3>
        </div>

    </body>
</html>
