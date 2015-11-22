<div id="footer">
  <div id="footerText" class="vCenter">
    <?php
      if (isset($_SESSION['username'])) {
        # Let user known they are logged in and give them the option to log out
        echo "Logged in as $_SESSION[username] (<a href='/admin/logout.php'>Logout</a>)";
      } else {
        # Login link
        echo "<a href='/admin.php'>Login</a>";
      }
    ?>
  </div>
</div>
