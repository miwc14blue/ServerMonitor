<?php

include_once("../lib/UserDAO.php");

session_start();

if (!isset($_SESSION['username']) || !($_SESSION['role'] == 'admin')) {
    header("Location:../login.php");
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>
        Gebruiker Overzicht
    </title>
    <script type="text/javascript" src="../js/popup.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles-userlist.css">
    <link rel="stylesheet" href="../css/styles-popup.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
    <?php require_once('menu.php'); ?>
    <div class="page">
        <div class="wrapper">
            <div class="header-container">
                <h2>Gebruiker Overzicht</h2>
                <a class="btn btn-aanmaken" href="userManipulation.php"><i class="fa fa-plus"></i> Nieuwe gebruiker aanmaken</a>
            </div>
            <table>
                <tr>
                    <th>GEBRUIKERSNAAM</th>
                    <th>VOORNAAM</th>
                    <th>ACHTERNAAM</th>
                    <th>ROL</th>
                    <th></th>
                </tr>
                <?php
                
                $userDAO = new UserDAO();
                $userList = json_decode($userDAO->retrieveUserList());

                foreach ($userList as $user) {
                    ?>
                <tr <?php if ($_SESSION['username'] == $user->userName) {
                        echo 'style="color:blue"';
                    } ?>>
                    <td>
                        <?php echo $user->userName ?>
                        <?php if ($_SESSION['username'] == $user->userName) {
                            echo '<span style="font-size:.8em">(currently logged in)</span>';
                        } ?>
                    </td>
                    <td>
                        <?php echo $user->firstName ?>
                    </td>
                    <td>
                        <?php echo $user->lastName ?>
                    </td>
                    <td>
                        <?php echo $user->role ?>
                    </td>

                    <td>
                        <a href="../API/UserEdit.php?userName=<?php echo $user->userName ?>'"><i class="fa fa-pencil"> </i></a>
<!--                TODO: Either modify the anchor or style the button please--> 
                        
                        <button id="btn"> <i class="fa fa-pencil" 
                        onclick="window.location.href='../API/UserEdit.php?userName=<?php echo $user->userName ?>'"> </i>  </button>

                        <!--                    Trigger/Open The Modal -->
                        <a class="trash" onclick="show('<?php echo $user->userName ?>')" <?php if ($_SESSION['username'] == $user->userName) {
                                                                                                echo 'style="visibility:hidden"';
                                                                                            } ?>>
                            <i class="fa fa-trash"></i>
                        </a>

                        <!--                    The Modal -->
                        <div id="myModal<?php echo $user->userName ?>" class="modal" onclick="hide('<?php echo $user->userName ?>')">

                            <!--                    Modal content -->
                            <div class="modal-content">
                                
                                <div id="popup">
                                <span class="close" onclick="hide('<?php echo $user->userName ?>')">&times;</span>
                                    <p id="popupTitle">Gebruiker verwijderen</p>
                                    <p id="popupText">Weet u zeker dat u <?php echo $user->userName ?> wilt verwijderen?</p>
                                </div>
                                <button id="cancelbtn" class="popupFooter" onclick="window.location.href='userListOverview.php'">Annuleren</button>
                                <button id="submitbtn" class="popupFooter" onclick="alert('Gebruiker is verwijderd');window.location.href='../API/UserDelete.php? userName=<?php echo $user->userName?>';"><?php echo $user->userName?> verwijderen</button>
                            </div>
                            
                        </div>

                    </td>
                </tr>

                <?php

            }     ?>
            </table>
</body>
</html>
