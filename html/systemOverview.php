<?php
session_start();
if(!isset($_SESSION['username'])){
   header("Location:../login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Systeem Overzicht</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/systemoverview-styles.css">
    </head>

    <body>
        <nav id="navHeader">
            <img class="logo" src="../img/logo.png">
            <a class="active" href="systemOverview.php">Systeem overzicht</a>
            <?php if($_SESSION['role']=='admin'){ ?>
              <a href="userListOverview.php">Gebruikers</a>
            <?php } ?>
            <a class="uitloggen" href="../API/logout.php">Uitloggen</a>
        </nav>

        <div class="VM-container">
          <h3>Systeem Overzicht</h3>

        <?php
        $username='makeitwork';
        $password='itWorkMake2018';
        $URL='https://makeitwork.local.mybit.nl:8443/vms/klanty/testing';

        $ch= curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $output = curl_exec($ch);
        $data = json_decode($output);

        curl_close($ch);

        foreach($data as $row){
          ?>
            <div class="VM">
              <div class="img-container">
                <img class="vm-image" src="../img/vm_icon.png">
                <?php if($row->latency < 1.2 ) {
                  $connection = "good";
                } else if ($row->latency > 1.45) {
                  $connection = "bad";
                } else {
                  $connection = "ok";
                }
                ?>
                <img class="connection-image" src="../img/<?php echo $connection; ?>-connection.png">
              </div>
              <table id="VM-table">
                <tr>
                  <th colspan="3">
                    <?php echo $row->name?>
                  </th>
                </tr>
                <tr>
                  <td>
                    <strong>Latency: </strong><?php echo $row->latency?> sec
                  </td>
                  <td>
                    <strong>Memory: </strong><?php echo $row->memory?> GB
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Storage: </strong><?php echo round($row->disk_size, 1)?> GB
                  </td>
                  <td>
                    <strong>vCPU: </strong><?php echo $row->vCPU?>
                  </td>
                </tr>
              </table>
            </div>
          <?php
          }
          ?>
      </div>
    </body>
</html>
