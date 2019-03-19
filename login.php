<?php
  session_start();
  include_once("../lib/databasePDO.php");

  $databasePDOInstance = new DatabasePDO();
  $conn = $databasePDOInstance->get();

  //Get password and username from user input
  $password = $_POST['password'];
  $username = $_POST['username'];

  $query = "SELECT * FROM user WHERE name='$username'";

  $result = $conn->query($sql);
  if ($result->num_rows === 1) {
      $row = $result->fetch(PDO::FETCH_ASSOC);
      if (password_verify($password, $row['password'])) {
          //Password matches, so create the session
          $_SESSION['username'] = $row['userID'];
          echo "Match";
      }else{
          echo  "The username or password do not match";
      }
  }

  if(isset($_POST['submit'])){
    SignIn();
  }

  $databasePDOInstance = null;
?>
