<?php
session_start();

if(!isset($_SESSION['username']) || !($_SESSION['role']=='admin')){
  header("Location:../login.php");
}

// Check if firstName is given in the get request parameter
// Default is on aanmaken.
$state = "aanmaken";

if(isset($_GET['firstName']) && !empty($_GET['firstName'])){
  $state = "bewerken";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Gebruiker <?php echo $state ?></title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <link rel="stylesheet" type="text/css" href="../css/styles-updateUserForm.css">
  <script type="text/javascript" src="../js/sessionDestroyer.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
  <?php
  require_once('menu.php');
  ?>

  <div class="page">
    <div class="wrapper">
      <div class="header-container">
        <h2>Gebruiker <?php echo $state ?></h2>
      </div>
      <form method="POST" action="../API/createUser.php">
        <div class="column-container">
          <div class="column column-left">
            <p>
              <label>Gebruikersnaam
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='userName' type="text" class="input-field"/>
              </label>
            </p>
            <p>
              <label>Wachtwoord
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='password1' type="text" class="input-field"/>
              </label>
            </p>
            <p>
              <label>Voornaam
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='firstName' type="text" class="input-field"/>
              </label>
            </p>
            <p>
              <label>Rol
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <select name="rol">
                  <option value="User">User</option>
                  <option value="Administrator">Administrator</option>
                </select>
              </label>
            </p>
          </div>

          <div class="column column-right">
            <p>
              <label>Herhaal wachtwoord
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='password2' type="text" class="input-field"/>
              </label>
            </p>
            <p>
              <label>Achternaam
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='lastName' type="text" class="input-field"/>
              </label>
            </p>
            <p>
              <label>Email-adres
                <span class="error"><?php echo "error-placeholder"; ?></span>
                <input name='email' type="text" class="input-field"/>
              </label>
            </p>
          </div>
        </div>

        <div class="zend">
          <a class="btn" href="userListOverview.php">Annuleren</a>
          <?php if($state=='bewerken'){ ?>
            <a class="btn btn-verwijderen" href="">Gebruiker verwijderen</a>
          <?php } ?>
          <a class="btn btn-opslaan" href="">Gebruiker <?php echo $state ?></a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>