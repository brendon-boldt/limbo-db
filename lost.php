<html>

<?php
# Connect to MySQL server and the database
require( 'includes/connect_db.php' ) ;

# Includes these helper functions
require( 'includes/item_helper.php' ) ;
if ($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
	$_POST['item'] = '';
	$_POST['owner'] = ''; 
	$_POST['phone'] = '';
	$_POST['email'] = '';
	$_POST['building'] = '';
	$_POST['room'] = '';
	$_POST['description'] = ''; 
}
else if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

	if (isset($_POST['report_lost'])) {
		$errors = array();

		$values = array();
		$values['item'] = $_POST['item'];
		$values['owner'] = $_POST['owner'];
		$values['phone'] = $_POST['phone'];
		$values['email'] = $_POST['email'];
		$values['building'] = $_POST['building'];
		$values['room'] = $_POST['room'];
		$values['description'] = $_POST['description'];
		$result = insert_item($dbc, $values, 'lost');
		$errors = validate_values($dbc, $values);
		if ($result != false && $errors == 0)
			Header("Location: /item.php?id=$result");
	}
}

# Show the link records
#show_link_records($dbc);

# Close the connection
?>


<head>
<title>Limbo - Lost</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<body>
<?php include 'header.html' ?>

<div id="content">
  <h1>Report/Search Lost Items</h1>
  <form id='lostForm' action='lost.php' method='POST'>
  <table id="formTable">
    <tr>
      <td>
        Item
      </td>
      <td>
        <input type="text" name="item" placeholder="What is the item?" value="<?php echo $_POST['item']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Name 
      </td>
      <td>
        <input type="text" name="owner" placeholder="Who lost the item?" value="<?php echo $_POST['owner']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Phone 
      </td>
      <td>
        <input type="text" name="phone" placeholder="Optional" value="<?php echo $_POST['phone']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Email 
      </td>
      <td>
        <input type="text" name="email" placeholder="Optional" value="<?php echo $_POST['email']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Building       
      </td>
      <td>
        <input type="text" name="building" placeholder="Where did you find it?" value="<?php echo $_POST['building']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Room 
      </td>
      <td>
        <input type="text" name="room" placeholder="Which room was it in?" value="<?php echo $_POST['room']; ?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Description
      </td>
      <td>
        <textarea name="description" form="lostForm" placeholder="Description" style="resize: vertical;" ><?php echo $_POST['description']; ?></textarea>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" name='search' value="Search"/>
        <input type="submit" name='report_lost' value="Report Lost"/>
      </td>
    </tr>
  </table>
  </form>

<?php
	if (isset($_POST['search'])) {
		$identifier = $_POST['search'];
		echo "<table id='resultsTable'>";
		echo '<tr><th>Item</th>';
		echo '<th>Owner</th>';
		echo '<th>Phone</th>';
		echo '<th>Email</th>';
		# Location name listed under 'name' in the query
		echo '<th>Building</th>';
		echo '<th>Room</th>';
		echo '<th>Description</th></tr>';
		$array = search_item($dbc, $_POST);	
		foreach($array as $item) {
			echo '<tr><td><a href=item.php?id=' . $item['item_id'] .'>' . $item['item'] . '</a></td>';
			# Location name listed under 'name' in the query
			echo '<td>' . $item['owner'] . '</td>';
			echo '<td>' . $item['phone'] . '</td>';
			echo '<td>' . $item['email'] . '</td>';
			echo '<td>' . $item['name'] . '</td>';
			echo '<td>' . $item['room'] . '</td>';
			echo '<td>' . $item['description'] . '</td></tr>';
		}
		echo "Click on the name of the item for more details!";
		echo "</table>";
	} elseif (isset($_POST['report_lost'])) {
		echo "<div style='margin-left:5em'>";
		foreach($errors as $e) {
			echo $e;
		}
		echo '</div>';
	}
?>



</div>


<?php include 'footer.html' ?>
</body>
</html>