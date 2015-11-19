<?php
session_start();
foreach($_SESSION as $k => $v)
	echo "$k => $v<br>";
?>
<?php include 'header.html' ?>



<?php include 'footer.html' ?>
