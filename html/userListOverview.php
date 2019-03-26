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
            Gebruikersoverzicht
        </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/userlist-styles.css">

    </head>


    <body>
      <?php
          require_once('menu.php');
      ?>
        <table>
            <tr>
                <th class="headerUserTable" colspan="6">Gebruikersoverzicht
                  <button class="btn" onclick="window.location.href='../API/CreateUserForm.php';"><i class="fa fa-plus"></i> Voeg gebruiker toe</button>
                </th>
            </tr>
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
                    <a href="updateUserForm.php" id="potlood"><i class="fa fa-pencil" ></i></a>
                </td>
                <td>
                    <a href="" id="prullenbak"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php
    } ?>
        </table>
    </body>

    </html>


