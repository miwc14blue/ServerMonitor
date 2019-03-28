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
        <link rel="stylesheet" href="../css/styles-systemoverview.css">
        <script type="text/javascript" src="../js/sessionDestroyer.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    </head>

    <body>
      <?php
          require_once('Menu.php');
      ?>

      <div class="page">
        <div class="VM-container">
          <h2>Systeem Overzicht</h2>

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
                <img class="connection-image" src="../img/connection-<?php echo $connection; ?>.png">
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
      </div>
    </body>
</html>
