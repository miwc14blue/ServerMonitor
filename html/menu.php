<nav class="menu-container">
  <div class="menu">
    <div class="links">
      <img class="logo" src="../img/logo.png">
      <?php if($_SESSION['role']=='admin'){ ?>
          <a class="<?php echo ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/systemOverview.php') ? 'active':''; ?>" href="systemOverview.php">MONITOR</a>
          <a class="<?php echo (($_SERVER['PHP_SELF'] == '/ServerMonitor/html/userListOverview.php') || ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/userManipulation.php')) ? 'active':''; ?>" href="userListOverview.php">GEBRUIKERS</a>
      <?php } ?>
    </div>
    <div class="uitloggen">
      <a href="../API/logout.php">UITLOGGEN</a>
    </div>
  </div>
</nav>
