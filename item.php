<?php
require( 'includes/connect_db.php' );
# Includes these helper functions
require( 'includes/search_helper.php' );

$data = search_item_by_id($dbc, $_GET['id']);
/*
foreach($data as $key => $value)
	echo $key . " => " . $value . "<br>";
*/
if ($data == -1) {
	echo "<h1>Item not found.</h1>";
	exit();
}
?>

<head>
<title>Limbo - Item</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.html' ?>
<div id='content'>
<h1 style="font-size: 42pt;">Item Information - <?php if ($data != -1) echo $data['item']; ?></h1>
<span style="font-size:18pt"><b>Status: </b><?php echo ucwords($data['status']) ?></span>

<br><br> <br> 
<i><h2>Contact Information</h2></i>
<span style="margin-right:4em"><b>Name: </b ><?php echo $data['owner'] . $data['finder'] ?></span>
<span style="margin-right:4em"><b>Phone: </b><?php echo $data['phone'] ?></span>
<span style="margin-right:4em"><b>Email: </b><?php echo $data['email'] ?></span>
</div>
<?php include 'footer.html' ?>
