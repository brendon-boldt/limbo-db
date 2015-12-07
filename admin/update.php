<?php
session_start();
if (!isset($_SESSION['username'])) {
	Header("Location: /admin.php");
	die;
}
require_once( '../includes/admin_tools.php' );
require_once( '../includes/connect_db.php' );

?>
<html>
<head>
<title>Limbo - Password Change</title>
<link rel="stylesheet" type="text/css" href="../limbo.css">
</head>
<body>
<?php include '../header.php' ?>
<?php include '../footer.php' ?>
<div id="content">
	<h1> Change User Information</h1>
	<form id='passwordForm' action='update.php' method='POST'>
	<table id="formTable">
	<tr>
		<td>
		Current Password
		</td>
		<td> 
		   <input type="password" name="current_pass" placeholder="Password" />
		</td>
	</tr>
	<br>
	<tr>
		<td>
		Enter New Password
		</td>
		<td>
		   <input type="password" name="new_pass" placeholder="Optional"/>
		</td>
	</tr>
	<tr>
		<td>
		Confirm New Password
		</td>
		<td>
		   <input type="password" name="confirm_pass" placeholder="Optional"/>
		</td>
	</tr>
	<br>
	<tr>
		<td>
		New Email	
		</td>
		<td>
		   <input type="text" name="new_email" placeholder="Optional"/>
		</td>
	</tr>
	
	<tr>
		<td>
		</td>
		<td>
			<input type="submit" name='password_change' value="Update Information"/>
		</td>
	</tr>
	</table>
	</form>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<?php
		if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
			if (!empty($_POST['new_email'])) {
				$result = change_email($dbc, $_SESSION['username'], $_POST['current_pass'],  $_POST['new_email']);
				echo $result . '<br>';
			}
			if (!(empty($_POST['new_pass']) || empty($_POST['confirm_pass']))) {
				$result = change_password($dbc, $_SESSION['username'], $_POST['current_pass'],  $_POST['new_pass'],  $_POST['confirm_pass']);
				echo $result . '<br>';
			}
		}
	?>
<br><br><br>
<br><br><br>
<a href='/admin/home.php'>Back</a>
</div>
</body>
</html>
