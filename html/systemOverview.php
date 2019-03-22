<?php
// session_start();
// if(!isset($_SESSION['username'])){
//    header("Location:../login.php");
// }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Systeem Overzicht
        </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/systemoverview-styles.css">

    </head>

    <body>
        <nav id="navHeader">
            <img class="logo" src="../img/logo.png">
            <!-- if role = user -> systeemOverzichtUser
            else -> systeemOverzichtAdm -->
            <a class="active" href="systeemOverzichtAdm.php">Systeem overzicht</a>
            <!-- if role = admin -->
            <a href="userListOverview.php">Gebruikers</a>
            <a class="uitloggen" href="../API/logout.php">Uitloggen</a>
        </nav>

        <h1>Systeem Overzicht</h1>

        <?php
        $ch= curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://makeitwork.local.mybit.nl/vms/klanty/testing');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $data = json_decode($output);

        curl_close($ch);

        var_dump(json_decode($output, true));

        foreach($data as $row){
          ?>
          <div class="VM-container">
            <div class="img-container">
              <img class="vm" src="../img/vm_icon.png">
            </div>
            <table border="1">
              <tr>
                <th colspan="3">
                  <?php echo $row->name?>
                </th>
              </tr>
              <tr>
                <td>
                  <?php echo $row->latency?>
                </td>
                <td>
                  <?php echo $row->memory?>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo $row->disk_size?>
                </td>
                <td>
                  <?php echo $row->vCPU?>
                </td>
              </tr>
            </table>
          </div>
        <?php
        }
        ?>
    </body>
</html>
