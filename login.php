<?php
include_once("lib/DatabasePDO.php");
session_start();

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

$nameErr = $passErr = $combiErr = '';
$myusername = $mypassword = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SESSION["username"])) unset($_SESSION["username"]);
  if (empty($_POST["username"])) {
    $nameErr = "Vul uw gebruikersnaam in...";
  } else {
    $myusername = $_POST["username"];
  }

  if (empty($_POST["password"])) {
    $passErr = "Vul uw wachtwoord in...";
  } else {
    $mypassword = $_POST["password"];

    $query = "SELECT * FROM user WHERE userName='$myusername'";

    try {
      $statement = $conn->prepare($query);
      $statement->execute();
    } catch (DPOException $e) {
      echo "Error: {$e->getMessage()}";
    }

    if ($statement->rowCount() === 1) {
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      // if statement with hash function: (password_verify($password, $row['password'])) No hash: ($password == $row['password'])
      if (password_verify($mypassword, $row['password']) && $row['deleted'] == 0) {
        //Password matches, so create the session
        $_SESSION['username'] = $row['userName'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
          $_SESSION['role'] = 'admin';
        } else {
          $_SESSION['role'] = 'user';
        }

        header("location: html/systemOverview.php");

      } else if ($row['deleted'] == 1) {
        $combiErr = "U heeft geen account meer.";
        // ingegeven wachtwoord matcht niet met db
      } else
        $combiErr = "Onbekende combinatie van gebruikersnaam en wachtwoord";
      // ingegeven username matcht niet met db
    } else {
      $combiErr = "Onbekende combinatie van gebruikersnaam en wachtwoord";
    }
  }
}

?>
<html>

<head>
    <title>Login Page</title>
    <link rel='stylesheet' href='css/styles.css' />
    <link rel='stylesheet' href='css/styles-login.css' />
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <div id="login">
        <h1 id="boxheader">Server Monitor</h1>
        <form action="" method="POST">
            <span class="error" id="combiErr"><?php echo $combiErr; ?></span>
            <label>Gebruikersnaam
              <span class="error"><?php echo $nameErr; ?></span>
              <input type="text" name="username" class="input-field" value="<?php echo htmlspecialchars($myusername); ?>" />
            </label>
            <label>Wachtwoord
              <span class="error"><?php echo $passErr; ?></span>
              <input type="password" name="password" class="input-field" value="<?php echo htmlspecialchars($mypassword); ?>" />
            </label>
            <a class="btn btn-inloggen" type="submit">Inloggen</a>
        </form>
    </div>
</body>

</html>
