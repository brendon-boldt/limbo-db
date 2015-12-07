<div id="footer">
  <div id="footerText" class="vCenter">
    <?php
      $root = realpath($_SERVER["DOCUMENT_ROOT"]);
      require_once("$root/includes/admin_tools.php");
      require_once("$root/includes/connect_db.php");

      if (isset($_SESSION['username'])) {
        # Let user known they are logged in and give them the option to log out
	$logout = "<a href='/admin/logout.php'>Logout</a>";
	$update = "<a href='/admin/update.php'>Update Information</a>";
        echo "Logged in as $_SESSION[username] | $logout | $update";
	if (is_super($dbc, $_SESSION['username'])) {
		$add = "<a href='/admin/add_admin.php'>Create/Delete Admin</a>";
		$query= "<a href='/admin/query.php'>Query</a>";
		echo " | $add | $query";
	}
      } else {
        # Login link
        echo "<a href='/admin.php'>Login</a>";
      }
    ?>
    <script type='text/javascript'>
	document.getElementsByTagName('body')[0].style.minHeight = window.innerHeight - 140;
    </script>
  </div>
</div>
