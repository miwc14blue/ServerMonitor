<?php
session_start();
   unset($_SESSION["username"]);

   echo 'Je bent uitgelogd';
   header('Refresh: 2; URL = login.php');
?>
