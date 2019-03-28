<?php
include_once("lib/DatabasePDO.php");
include_once("lib/User.php");
include_once("lib/UserDAO.php");
ini_set('session.cache_limiter', 'private');
session_start();

$_SESSION['nameErr'] = $_SESSION['passErr'] = $_SESSION['combiErr'] = '';
$_SESSION['postUsername'] = '';
$username = $password = '';
$isDeleted = $loggedIn = $sessionStarted = false;

//main:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['postUsername'] = $_POST['username'];
  resetSession();
  $isFilledIn = isFilledIn();

  if ($isFilledIn) {
    $user = retrieveUser();
  }
  if ($isFilledIn && !empty($user)) {
    $isDeleted = checkForDeletion($user);
    if (!$isDeleted) $loggedIn = tryToLogin($user);
  }

  if ($isFilledIn && !$loggedIn && $isDeleted == false) {
    $_SESSION['combiErr'] = "Onbekende combinatie van gebruikersnaam en wachtwoord";
  }
} else if (isset($_SESSION['username'])) {
  header("location: html/SystemOverview.php");
} else {
  header('login.php');
}

include_once("html/LoginPage.php");

//functions:
function resetSession()
{
  if (isset($_SESSION["username"])) unset($_SESSION["username"]);
}

function isFilledIn()
{
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

function retrieveUser()
{
  $userDAO = new UserDAO();
  $data = $userDAO->findUser($_POST["username"]);
  return json_decode($data);
}

function checkForDeletion($user)
{
  if ($user[0]->deleted == 1) {
    $_SESSION['combiErr'] = "U heeft geen account meer.";
    return true;
  }
}

function tryToLogin($user)
{
  if (password_verify($_POST["password"], $user[0]->password)) {
    $_SESSION['username'] = $user[0]->userName;
    $_SESSION['role'] = $user[0]->role;
    $_POST = array();
    header("location: html/SystemOverview.php");
    return true;
  } else return false;
}
 