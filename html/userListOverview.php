<?php

include_once("../lib/UserDAO.php");

session_start();
if(!isset($_SESSION['username']) || !($_SESSION['role']=='admin')){
   header("Location:../login.php");
}
?>

<!DOCTYPE html>
    <html>

    <head>
        <title>
            Gebruiker Overzicht
        </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/userlist-styles.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    </head>
    <body>
      <?php
          require_once('menu.php');
      ?>
      <div class="page">
        <div class="wrapper">
          <div class="header-container">
            <h3>Gebruiker Overzicht</h3>
            <button class="btn" onclick="window.location.href='../API/CreateUserForm.php';"><i class="fa fa-plus"></i> Nieuwe gebruiker aanmaken</button>
          </div>
          <table>
              <!-- <tr>
                  <th colspan="6">
                    <h3>Gebruikersoverzicht</h3>

                  </th>
              </tr> -->
              <tr>
                  <th>GEBRUIKERSNAAM</th>
                  <th>VOORNAAM</th>
                  <th>ACHTERNAAM</th>
                  <th>ROL</th>
                  <th></th>
                  <th></th>
              </tr>
              <?php

              $userDAO = new UserDAO();
              $userList = json_decode($userDAO->retrieveUserList());

              foreach($userList as $user){
                          ?>
              <tr>
                  <td>
                      <?php echo $user->userName?>
                  </td>
                  <td>
                      <?php echo $user->firstName?>
                  </td>
                  <td>
                      <?php echo $user->lastName?>
                  </td>
                  <td>
                      <?php echo $user->role?>
                  </td>
                  <td>
                      <i class="fa fa-pencil"></i>
                  </td>
                  <td>
                      <i class="fa fa-trash"></i>
                  </td>
              </tr>
              <?php
              } ?>
          </table>
        </div>
      </div>
    </body>

    </html>
