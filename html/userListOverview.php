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
              <button> <i class="fa fa-pencil"> </i> </button>
<!--                    HIER KOMT FRANK&ANDY'S LINK NAAR CREATE USER FORM MET MEEGEGEVEN USER VALUES, WAARDOOR HET EEN EDIT FORM WORDT -->
                    
                </td>
                <td >
<!--                    No trash icon for currently logged in Admin -->
                   <button class="btn" 
                           <?php if($_SESSION['username'] == $user->userName) { echo 'style="visibility:hidden"';} ?> 
                           onclick="window.location.href='../API/deleteUser.php? userName=<?php echo $user->userName?>';" >
                    <i class="fa fa-trash" ></i>
                </td>
            </tr>
            
            <?php
    } 
            
    ?>
        </table>
    </body>

    </html>
