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
      
            foreach($userList as $user){
                        ?>
            <tr <?php if($_SESSION['username'] == $user->userName) { echo 'style="color:blue"';}?>>
                <td >
                    <?php echo $user->userName?>
                    <?php if($_SESSION['username'] == $user->userName) { echo '<span style="font-size:.8em">(currently logged in)</span>';}?>
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
                    <button id="btn"> <i class="fa fa-pencil" onclick="window.location.href='../API/UserEdit.php?userName=<?php echo $user->userName ?>'"> </i>  </button>
<!--                    HIER STAAT FRANK&ANDY'S LINK NAAR CREATE USER FORM MET MEEGEGEVEN USER VALUES, WAARDOOR HET EEN EDIT FORM WORDT -->

                </td>
                <td>
                    
<!--                    Trigger/Open The Modal -->
                    <button id="btn myBtn" onclick="show('<?php echo $user->userName?>')" 
                        <?php if($_SESSION['username'] == $user->userName) { echo 'style="visibility:hidden"';} ?>>
                        <i class="fa fa-trash"></i>
                    </button>

<!--                    The Modal -->
                    <div id="myModal<?php echo $user->userName?>" class="modal">

<!--                    Modal content -->
                        <div class="modal-content">
                            <span class="close" onclick="hide('<?php echo $user->userName?>')">&times;</span>
                            <div>
                                <h5 id="popupTitle">Gebruiker verwijderen</h5>
                                <p id="popupText">Weet u zeker dat u <?php echo $user->userName?> wilt verwijderen?</p>
                                <button class="cancelbtn" onclick="window.location.href='userListOverview.php'">Annuleren</button>
                                <button class="submitbtn" onclick="window.location.href='../API/UserDelete.php? userName=<?php echo $user->userName?>';"><?php echo $user->userName?> verwijderen</button>
<html>

<head>
    <title>
        Gebruiker Overzicht
    </title>
    <script type="text/javascript" src="../js/popup.js"></script>
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
                        <a href="userManipulation.php"><i class="fa fa-pencil"></i></a>
                        <!--                    HIER KOMT FRANK&ANDY'S LINK NAAR CREATE USER FORM MET MEEGEGEVEN USER VALUES, WAARDOOR HET EEN EDIT FORM WORDT -->

                        <!--                    Trigger/Open The Modal -->
                        <a class="trash" onclick="show('<?php echo $user->userName ?>')" <?php if ($_SESSION['username'] == $user->userName) {
                                                                                                echo 'style="visibility:hidden"';
                                                                                            } ?>>
                            <i class="fa fa-trash"></i>
                        </a>

                        <!--                    The Modal -->
                        <div id="myModal<?php echo $user->userName ?>" class="modal">

                            <!--                    Modal content -->
                            <div class="modal-content">
                                <span class="close" onclick="hide('<?php echo $user->userName ?>')">&times;</span>
                                <div>
                                    <h5 id="popupTitle">Gebruiker verwijderen</h5>
                                    <p id="popupText">Weet u zeker dat u <?php echo $user->userName ?> wilt verwijderen?</p>
                                    <button class="cancelbtn" onclick="window.location.href='userListOverview.php'">Annuleren</button>
                                    <button class="submitbtn" onclick="window.location.href='../API/UserDelete.php? userName=<?php echo $user->userName ?>';"><?php echo $user->userName ?> verwijderen</button>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>

                <?php

            }     ?>
            </table>
</body>

</html>
