<html>
<head>
<title>Limbo - Password Change</title>
<link rel="stylesheet" type="text/css" href="/limbo.css">
</head>
<body>
<?php include '../header.php' ?>
<?php include '../footer.php' ?>
<div id="content">
<div align="right">
		Search | Add Admin | Change Password
	</div>
	<h1> Add Administrator</h1>
	<form id='passwordForm' action='change_password.php' method='POST'>
	<table id="formTable">
	<tr>
		<td>
		Enter Username
		</td>
		<td> 
		   <input type="text" name="current_password" placeholder="Your desired username here" />
		</td>
	</tr>
	<tr>
		<td>
		Enter Password
		</td>
		<td>
		   <input type="text" name="New Password" placeholder="Your password here"/>
		</td>
	</tr>
	<tr>
		<td>
		Confirm Password
		</td>
		<td>
		   <input type="text" name="Confirm Password" placeholder="Confirm your password here" "/>
		</td>
	</tr>
	
	<tr>
		<td>
		</td>
		<td>
			<input type="submit" name='password_change' value="Create Administrator"/>
		</td>
	</tr>
	</table>
	</form>
</div>
</body>
</html>
