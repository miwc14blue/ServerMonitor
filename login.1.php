<?php
include_once("lib/DatabasePDO.php");
include_once("lib/Query.php");
include_once("lib/User.php");
session_start();

$_SESSION['nameErr'] = $_SESSION['passErr'] = $_SESSION['combiErr'] = '';
$username = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  resetSession();
  $testInput = testInput();

  if ($testInput) {
    $query = new Query();
    $user = $query->queryUserByUserName($_POST["username"]);
    $password = $user->getHash();
  }

  if ($testInput && password_verify($_POST["password"], $password) && $user->deleted() == 0) {
    //Password matches, so create the session
    $_SESSION['username'] = $user->getUserName();
    $_SESSION['role'] = $user->getRole();
    toWelcomePage();
  } else if ($testInput && $user->deleted() == 1) {
    $_SESSION['combiErr'] = "U heeft geen account meer.";
    // ingegeven wachtwoord matcht niet met db
  } else
  $_SESSION['combiErr'] = "test Onbekende combinatie van gebruikersnaam en wachtwoord";
  // ingegeven username matcht niet met db 
} else if (isset($_SESSION['username'])) {
  toWelcomePage();
} else header('login.1.php');


function resetSession()
{
  if (isset($_SESSION["username"])) unset($_SESSION["username"]);
}

function testInput()
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

function toWelcomePage()
{
  if ($_SESSION['role'] == 'admin') {
    header("location: html/systeemOverzichtAdm.php");
  } else if ($_SESSION['role'] == 'user') {
    header("location: html/systeemOverzichtUser.php");
  }
}


?>
<html>

<head>
    <title>Login Page</title>
    <link rel='stylesheet' href='css/styles.css' />
    <link rel='stylesheet' href='css/styles-login.css' />
</head>

<body>
    <div id="login">
        <h1 id="boxheader">Server Monitor</h1>
        <form action="" method="POST">
            <span class="error" id="combiErr"><?php echo $_SESSION['combiErr']; ?></span>
            <span class="error"><?php echo $_SESSION['nameErr']; ?></span>
            <label>Gebruikersnaam: <input type="text" name="username" class="field" value="<?php echo htmlspecialchars($username); ?>" /></label>
            <span class="error"><?php echo $_SESSION['passErr']; ?></span>
            <label>Wachtwoord: <input type="password" name="password" class="field" value="" /></label>
            <input id="button" type="submit" value="Inloggen" />
        </form>
    </div>
</body>

</html> 