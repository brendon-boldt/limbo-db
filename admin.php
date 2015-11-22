<?php
session_start();
require_once('includes/login_tools.php');
require_once('includes/connect_db.php');

$result = true;
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$result = validate($dbc, $_POST['username'], $_POST['password']);
	if ($result != false) {
		session_start();
		$_SESSION['username'] = $result;
		Header("Location: /admin/home.php");
	}
} elseif (isset($_SESSION['username'])) {
	Header("Location: /admin/home.php");
}
?>
<head>
<title>Limbo - Admin</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.php' ?>

<div id='content'>
<h1>Admin Login</h1>

  <form id='loginForm' action='admin.php' method='POST'>
  <table id="formTable">
    <tr>
      <td>
       	Username 
      </td>
      <td>
        <input type="text" name="username" placeholder="Username"/ required>
      </td>
    </tr>
    <tr>
      <td>
      	Password
      </td>
      <td>
        <input type="password" name="password" placeholder="Password"/ required>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" value="Login" />
      </td>
    </tr>
  </table>
  </form>

  <?php
	if ($result == false) {
		echo "Incorrect username or password.<br>";
	}
  ?>
</div>



<?php include 'footer.php' ?>
