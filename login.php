<?php
include_once("lib/DatabasePDO.php");
include_once("lib/Query.php");
include_once("lib/User.php");
include_once("lib/UserDAO.php");
session_start();
header('login.1.php');

$_SESSION['nameErr'] = $_SESSION['passErr'] = $_SESSION['combiErr'] = '';
$username = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  resetSession();
  $testInput = testInput();

  if ($testInput) {
    $userDAO = new UserDAO();
    $data = $userDAO->findUser($_POST["username"]);
    $user = json_decode($data);
  }

  if ($testInput && $user != "[]") {
    $loggedIn = tryLogin($user);
  }


  if ($testInput && !$loggedIn && $user[0]->deleted == 1) {
    $_SESSION['combiErr'] = "U heeft geen account meer.";
  } else if ($testInput && !$loggedIn) {
    $_SESSION['combiErr'] = "Onbekende combinatie van gebruikersnaam en wachtwoord";
  }
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

function tryLogin($user)
{
  if (password_verify($_POST["password"], $user[0]->password) && $user[0]->deleted == 0) {
    $_SESSION['username'] = $user[0]->userName;
    $_SESSION['role'] = $user[0]->role;
    toWelcomePage();
    return true;
  } else return false;
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
