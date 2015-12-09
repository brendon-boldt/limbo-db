<?php
session_start();
# Checks to see if uses is an admininstrator
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
<link rel="stylesheet" type="text/css" href="/limbo.css">
</head>
<body>
<?php include '../header.php' ?>
<?php include '../footer.php' ?>
<div id="content">
	<h1>Create Administrator</h1>
	<form id='adminForm' action='add_admin.php' method='POST'>
	<table id="formTable">
	<tr>
		<td>
		Enter New Admin Username
		</td>
		<td> 
		   <input type="text" name="target_admin" placeholder="Username" />
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<input type="submit" name='add' value="Create"/>
			<input type="submit" name='delete' value="Delete"/>
		</td>
	</tr>
	</table>
	</form>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<?php
		if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
			# Determines whether to add or delete the entered admin name
			if(isset($_POST['add'])) {
				$result = add_admin($dbc, $_SESSION['username'], $_POST['target_admin']);
				echo $result . '<br>';
			} elseif(isset($_POST['delete'])) {
				$result = delete_admin($dbc, $_SESSION['username'], $_POST['target_admin']);
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
