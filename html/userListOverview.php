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
        <script type="text/javascript" src="../js/popup.js"></script>
        <link rel="stylesheet" href="../css/reset.css">
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
          //<?php $userDAO->deleteUser($user->userName);


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
                    <button id="btn"> <i class="fa fa-pencil"></i> </button>
<!--                    HIER KOMT FRANK&ANDY'S LINK NAAR CREATE USER FORM MET MEEGEGEVEN USER VALUES, WAARDOOR HET EEN EDIT FORM WORDT -->
                <td>

                   <button class="btn" onclick="window.location.href='../lib/deleteUser.php? userName=<?php echo $user->userName?>';" >   <i class="fa fa-trash"></i>

                   <!-- <button class="btn" onclick="window.location.href='../API/deleteUser.php? userName=<?php echo $user->userName?>';" >   <i class="fa fa-trash"></i> -->
                    
                    <!-- Trigger/Open The Modal -->
                    <button id="btn myBtn" onclick="show('<?php echo $user->userName?>')">
                        <i class="fa fa-trash"></i>
                    </button>

                    <!-- The Modal -->
                    <div id="myModal" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content">
                            <span class="close" onclick="hide()">&times;</span>
                            <p>
                                <h5>Gebruiker verwijderen</h5>
                                <p id="popuptext"></p>
                            </p>
                            <p>
                                <button class="cancelbtn" onclick="window.location.href='userListOverview.php'">Annuleren</button>
                                <!-- onderstaande submitbtn heeft waarde nodig die wordt meegegeven -->
                                <button class="submitbtn" onclick="../API/deleteUser.php">Gebruiker verwijderen</button>
                            </p>
                        </div>
                    </div>

                </td>
            </tr>
            
            <?php
    }     ?>
        </table>
    </body>

    </html>
