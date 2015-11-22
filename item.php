<?php
session_start();
require_once( 'includes/connect_db.php' );
# Includes these helper functions
require_once( 'includes/search_helper.php' );
require_once( 'includes/item_helper.php' );

if(empty($_GET['id'])) {
	$_GET['id'] = -1;
}
$data = search_item_by_id($dbc, $_GET['id']);
if ($data == -1) {
	header("Location: /searchreport.php");
}

if (isset($_POST['action'])) {
	perform_action($dbc, $_GET['id'], $_POST['action']);
	header("Refresh:0");
}
?>

<head>
<title>Limbo - Item</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.php' ?>
<div id='content'>
<h1 style="font-size: 42pt;">Item Information - <?php if ($data != -1) echo $data['item']; ?></h1>
<span style="font-size:18pt"><b>Status: </b><?php echo ucwords($data['status']) ?></span><br>
<?php echo "Near $data[room] in " . get_location_name($dbc, $data['id']); ?><br><br>

<h2>Description</h2>
<?php echo $data['description'] ?><br><br><br>

<i><h2>Contact Information</h2></i>
<span style="margin-right:4em"><b>Name: </b ><?php echo $data['owner'] . $data['finder'] ?></span>
<span style="margin-right:4em"><b>Phone: </b><?php echo $data['phone'] ?></span>
<span style="margin-right:4em"><b>Email: </b><?php echo $data['email'] ?></span>
<br><br> <br><br>
<i>
Date Created - <?php echo $data['create_date'] ?><br>
Date Updated - <?php echo $data['update_date'] ?>
</i>


<?php
if (isset($_SESSION['username'])) {
	echo '<br><br><br>';
	echo "Actions: <form name='form' target='item.php?id=$_GET[id]' method='post'><select name='action'>
		<option value='lost'>Change status to lost</option>
		<option value='found'>Change status to found</option>
		<option value='delete'>Delete item</option>
	</select>
	<input type='submit' value='Submit'/>
	</form>";
}
?>
<br><br><br>
<a href='/searchreport.php?status=<?php echo $data['status'] ?>'>Back</a>
</div>
<?php include 'footer.php' ?>
