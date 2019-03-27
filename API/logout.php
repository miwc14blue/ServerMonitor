<?php
session_start();
   unset($_SESSION["username"]);

   echo 'Je bent uitgelogd';
   header('Refresh: 1; URL = ../login.php');
?>
