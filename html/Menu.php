<nav class="menu-container">
  <div class="menu">
    <div class="links">
      <div class="logo">
        <h1>Server Monitor</h1>
      </div>
      <?php if($_SESSION['role']=='admin'){ ?>
          <a class="<?php echo ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/SystemOverview.php') ? 'active':''; ?>" href="SystemOverview.php">MONITOR</a>
          <a class="<?php echo (($_SERVER['PHP_SELF'] == '/ServerMonitor/html/UserList.php') || ($_SERVER['PHP_SELF'] == '/ServerMonitor/html/UserEdit.php')) ? 'active':''; ?>" href="UserList.php">GEBRUIKERS</a>
      <?php } ?>
    </div>
    <div class="uitloggen">
      <a href="../API/Logout.php">UITLOGGEN</a>
    </div>
  </div>
</nav>
