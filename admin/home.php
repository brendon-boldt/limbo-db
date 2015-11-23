<?php
session_start();
if (!isset($_SESSION['username']))
	Header("Location: /admin.php");
?>
<head>
<title>Limbo - Admin</title>
<link rel="stylesheet" type="text/css" href="/limbo.css">
</head>
<?php include '../header.php' ?>

<div id='content'>

<h1><?php echo "Welcome, $_SESSION[username]!" ?></h1>
To update the status and delete items, search for <a href='/searchreport.php?status=lost'>lost</a> or  <a href='/searchreport.php?status=foudn'>found</a>  items and go directly to its details page.

<br><br><br> <br><br><br>
<a href='/'>Back</a>
</div>
<?php include '../footer.php' ?>
