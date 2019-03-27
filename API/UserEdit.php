<?php
include 'UserDAO.php';

$userName = $_GET["userName"];
if (!empty($userName)){
    $userDAO = new UserDAO();
    $userDAO->editUser($userName);
    }
     
?>