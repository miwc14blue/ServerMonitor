<?php
include_once("lib/DatabasePDO.php");
include_once("lib/User.php");
include_once("lib/UserDAO.php");
session_start();

$_SESSION['nameErr'] = $_SESSION['passErr'] = $_SESSION['combiErr'] = '';
$_SESSION['postUsername'] = '';
$username = $password = '';
$deleted = $loggedIn = $sessionStarted = false;

//main:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['postUsername'] = $_POST['username'];
  resetSession();
  $isFilledIn = isFilledIn();

  if ($isFilledIn) {
    retrieveUser();
  }
  if ($isFilledIn && !empty($user)) {
    checkForDeletion($user);
     else $loggedIn = tryLogin($user);
  }

  if ($isFilledIn && !$loggedIn && $deleted == false) {
    $_SESSION['combiErr'] = "Onbekende combinatie van gebruikersnaam en wachtwoord";
    $_POST = array();
  }
} else if (isset($_SESSION['username'])) {
  header("location: html/systemOverview.php");
} else {
  header('login.php');
}

include_once("html/loginPage.php");

//functions:
function resetSession()
{
  if (isset($_SESSION["username"])) unset($_SESSION["username"]);
}
function retrieveUser(){
  $userDAO = new UserDAO();
  $data = $userDAO->findUser($_POST["username"]);
  $user = json_decode($data);
}
function checkForDeletion(){
if ($user[0]->deleted == 1) {
      $_SESSION['combiErr'] = "U heeft geen account meer.";
      $deleted = true;
    }
}


function isFilledIn($user) {
  $filledIn = true;
  if (empty($_POST["username"])) {
    $_SESSION['nameErr'] = "Vul uw gebruikersnaam in...";
    $filledIn = false;
  }
  if (empty($_POST["password"])) {
    $_SESSION['passErr'] = "Vul uw wachtwoord in...";
    $filledIn = false;
  }
  return $filledIn;
}

function tryLogin($user)
{
  if (password_verify($_POST["password"], $user[0]->password)) {
    $_SESSION['username'] = $user[0]->userName;
    $_SESSION['role'] = $user[0]->role;
    $_POST = array();
    header("location: html/systemOverview.php");
    return true;
  } else return false;
}


?>