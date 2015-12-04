<?php
session_start();
if (!isset($_SESSION['username']))
	Header("Location: /admin.php");
else
	include("../includes/admin/update.php");
?>
