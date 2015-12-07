<?php
session_start();
require_once( 'includes/connect_db.php' );
# Includes these helper functions
require_once( 'includes/search_helper.php' );
require_once( 'includes/item_helper.php' );

# If no id is set, give it a default of -1
if(empty($_GET['id'])) {
	$_GET['id'] = -1;
}
# Search for the item specified by id in the database
$data = search_item_by_id($dbc, $_GET['id']);
if ($data == -1) {
  # If no id matches, redirect to the search page
	header("Location: /searchreport.php");
}

if (isset($_POST['action'])) {
  # If the admin specified an update/delete action, perform it now
	perform_action($dbc, $_GET['id'], $_POST['action']);
  # Refresh to show updates
	header("Refresh:0");
}
?>

<head>
<title>Limbo - Item</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.php' ?>
<div id='content'>
<!-- Display Item information here -->
<h1 style="font-size: 42pt;">Item Information - <?php if ($data != -1) echo $data['item']; ?></h1>
<span style="font-size:18pt"><b>Status: </b><?php echo ucwords($data['status']) ?></span><br>
<?php echo "Near $data[room] in " . get_location_name($dbc, $data['location_id']); ?><br><br>

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
# If an admin is logged in, display update/delete actions
if (isset($_SESSION['username'])) {
	echo '<br><br><br>';
	echo "Item ID: $data[id]<br><br>";
	#echo "Actions: <form name='form' target='item.php?id=$_GET[id]' method='post'><select name='action'>
	echo "Actions: <form name='form' target='_self' method='post'><select name='action'>
		<option value='lost'>Change status to lost</option>
		<option value='found'>Change status to found</option>
		<option value='claimed'>Change status to claimed</option>
		<option value='update'>Update item</option>
		<option value='delete'>Delete item</option>
	</select>
	<input type='submit' value='Submit' target='_self'/>
	</form>";
}
?>
<br><br><br>
<a href='/searchreport.php?status=<?php echo $data['status'] ?>'>Back</a>
</div>
<?php include 'footer.php' ?>
