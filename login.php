<?php
include_once("lib/DatabasePDO.php");
session_start();

$databasePDOInstance = new DatabasePDO();
$conn = $databasePDOInstance->get();

$nameErr = $passErr = $combiErr = '';
$myusername = $mypassword = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (empty($_POST["username"])) {
     $nameErr = "Vul uw gebruikersnaam in...";
 }
 else {
     $myusername = $_POST["username"];
 }

 if (empty($_POST["password"])) {
     $passErr = "Vul uw wachtwoord in...";
 } else {
     $mypassword = $_POST["password"];

     $query = "SELECT * FROM user WHERE userName='$myusername'";

     try{
       $statement = $conn->prepare($query);
       $statement->execute();
     } catch (DPOException $e){
       echo "Error: {$e->getMessage()}";
     }

     if ($statement->rowCount() === 1) {
         $row = $statement->fetch(PDO::FETCH_ASSOC);
         // if statement with hash function: (password_verify($password, $row['password'])) No hash: ($password == $row['password'])
         if (password_verify($mypassword, $row['password']) && $row['deleted']==0) {
             //Password matches, so create the session
             $_SESSION['username'] = $row['userName'];

             if ($row['role']=='admin') {
               header("location: html/systeemOverzichtAdm.php");
               $_SESSION['role']='admin';
             } else {
               header("location: html/systeemOverzichtUser.php");
               $_SESSION['role']='user';
             }
         } else if($row['deleted']==1) {
           $combiErr = "U heeft geen account meer.";
         }
     } else {
         $combiErr = "Inloggegevens kloppen niet, probeer het opnieuw...";
     }
 }
}

?>
<html>
   <head>
      <title>Login Page</title>
      <link rel='stylesheet' href='css/styles.css'/>
      <link rel='stylesheet' href='css/styles-login.css'/>
   </head>
   <body id="body-color">
      <div id="login">
        <h1 id="boxheader">Server Monitor</h1>
        <form action="" method="POST">
          <span class="error" id="combiErr"><?php echo $combiErr;?></span>
          <span class="error"><?php echo $nameErr;?></span>
          <label>Gebruikersnaam: <input type="text" name="username" class="field" value="<?php echo htmlspecialchars($myusername);?>"/><br /><br /></label>
          <span class="error"><?php echo $passErr;?></span>
          <label>Wachtwoord: <input type="password" name="password" class="field" value="<?php echo htmlspecialchars($mypassword);?>"/><br/><br /></label>
          <input id="button" type="submit" value="Inloggen"/><br />
        </form>
      </div>
   </body>
</html>
