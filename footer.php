<div id="footer">
  <div id="footerText" class="vCenter">
    <?php
      if (isset($_SESSION['username'])) {
        echo "Logged in as $_SESSION[username] (<a href='/admin/logout.php'>Logout</a>)";
      } else {
        echo "<a href='/admin.php'>Login</a>";
      }
    ?>
  </div>
</div>
