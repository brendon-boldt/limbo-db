<?php
# Session started to check if the user is logged in
session_start();
require_once('includes/login_tools.php');
require_once('includes/connect_db.php');

# Give a default value to result
$result = true;
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
  # Check if the username and password match something in the database
	$result = validate($dbc, $_POST['username'], $_POST['password']);
  # If the validation occurred succesfully
	if ($result != false) {
		session_start();
		$_SESSION['username'] = $result;
    # The user is now logged in and will be redirected to the admin home
		Header("Location: /admin/home.php");
	}
} elseif (isset($_SESSION['username'])) {
  # Redirect to admin home is user is already loged in
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

<br><br><br>
<br><br><br>
<a href='/'>Back</a>
</div>



<?php include 'footer.php' ?>
