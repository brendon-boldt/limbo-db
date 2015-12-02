<?php
require_once( '../admin_tools.php.' );

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
<div align="right">
		Search | Add Admin | Change Password
	</div>
	<h1> Change Administrator Passwords</h1>
	<form id='passwordForm' action='change_password.php' method='POST'>
	<table id="formTable">
	<tr>
		<td>
		Current Password
		</td>
		<td> 
		   <input type="text" name="current_pass" placeholder="Your current password here" />
		</td>
	</tr>
	<tr>
		<td>
		Enter New Password
		</td>
		<td>
		   <input type="text" name="new_pass" placeholder="Your new password here"/>
		</td>
	</tr>
	<tr>
		<td>
		Confirm New Password
		</td>
		<td>
		   <input type="text" name="confirm_pass" placeholder="Confirm your password here"/>
		</td>
	</tr>
	
	<tr>
		<td>
		</td>
		<td>
			<input type="submit" name='password_change' value="Change Password"/>
		</td>
	</tr>
	</table>
	</form>
	<br><br><br>
	<?php
		if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
			$result = change_password($_SESSION['username'], $_POST['current_pass'],  $_POST['new_pass'],  $_POST['confirm_pass']);
			if ($result) {
				echo "Password change successful";
			}
		}
	?>
</div>
</body>
</html>
