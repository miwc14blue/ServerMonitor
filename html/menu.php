<nav id="navHeader">
  <img class="logo" src="../img/logo.png">
  <a class="<?php echo ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/systeemOverzichtAdm.php') ? 'active':''; ?>" href="systeemOverzichtAdm.php">Systeem overzicht</a>
  <?php if($_SESSION['role']=='admin'){ ?>
    <a class="<?php echo ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/userListOverview.php') ? 'active':''; ?>" href="userListOverview.php">Gebruikers</a>
  <?php } ?>
  <a class="uitloggen" href="../API/logout.php">Uitloggen</a>
</nav>
