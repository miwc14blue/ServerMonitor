<?php
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

        <nav id="navHeader">
            <img class="logo" src="../img/logo.png">
            <a href="systeemOverzichtAdm.php">Systeem overzicht</a>
            <a class="active" href="userListOverview.php">Gebruikers</a>
            <a class="uitloggen" href="../API/logout.php">Uitloggen</a>
        </nav>

        <table>
            <tr>
                <th class="headerUserTable" colspan="6">Gebruikersoverzicht
                  <button class="btn" onclick="window.location.href='../html/makeUserForm.php';"><i class="fa fa-plus"></i> Voeg gebruiker toe</button>
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
            $ch= curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1/ServerMonitor/API/getUserList.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $output = curl_exec($ch);
            $data = json_decode($output);

            curl_close($ch);

            foreach($data as $row){
                        ?>
            <tr>
                <td>
                    <?php echo $row->userName?>
                </td>
                <td>
                    <?php echo $row->firstName?>
                </td>
                <td>
                    <?php echo $row->lastName?>
                </td>
                <td>
                    <?php echo $row->role?>
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
    </body>

    </html>
