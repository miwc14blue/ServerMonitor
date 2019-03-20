<?php
   include_once('lib/DatabasePDO.php');
   session_start();

   $databasePDOInstance = new DatabasePDO();
   $conn = $databasePDOInstance->get();

   $user_check = $_SESSION['login_user'];

   $sql = "SELECT userName FROM user WHERE userName = '$user_check'";
   $result = $conn->query($sql);

   $row =  $result->fetch(PDO::FETCH_ASSOC);

   $login_session = $row['userName'];

   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>
