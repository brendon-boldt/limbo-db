<?php
session_start();
# Connect to MySQL server and the database
require( 'includes/connect_db.php' ) ;
# Includes these helper functions
require( 'includes/item_helper.php' ) ;

# If lost/found is not specified, set the status to lost
if (!isset($_GET['status'])) {
	$_GET['status'] = 'lost';
}
$page_status = $_GET['status'];
# If the status is something other than lost or found, set it to lost
if ($page_status != 'lost' && $page_status != 'found')
	$page_status = 'lost';
# If the item is lost, we want to know about the owner; if found, the finder
if ($page_status == 'lost')
	$person = 'owner';
else
	$person = 'finder';

# Make all fields empty by default
if ($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
	$_POST['item'] = '';
	$_POST[$person] = ''; 
	$_POST['phone'] = '';
	$_POST['email'] = '';
	$_POST['building'] = '';
	$_POST['room'] = '';
	$_POST['description'] = ''; 
}
else if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

  # If a report action was submitted, insert the information into the database
	if (isset($_POST['report_lost'])) {
		$errors = array();

		$values = array();
		$values['item'] = $_POST['item'];
		$values[$person] = $_POST[$person];
		$values['phone'] = $_POST['phone'];
		$values['email'] = $_POST['email'];
		$values['building'] = $_POST['building'];
		$values['room'] = $_POST['room'];
		$values['description'] = $_POST['description'];
		$result = insert_item($dbc, $values, $page_status);
    # Check for any errors
		$errors = validate_values($dbc, $values);
    if ($result != false && $errors == 0) {
      # If the record was inserted successfully, redirect to the item information page
			Header("Location: /item.php?id=$result");
    }
	}
}
?>


<head>
<title>Limbo - <?php echo ucwords($page_status) ?></title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<body>
<?php include 'header.php' ?>

<div id="content">
  <h1>Report/Search <?php echo ucwords($page_status)?> Items</h1>
  <form id='form' action='searchreport.php?status=<?php echo $page_status ?>' method='POST'>
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
        <input type="text" name=<?php echo $person ?> placeholder="Who <?php echo $page_status ?> the item?" value="<?php echo $_POST[$person]; ?>"/>
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
        <input type="text" name="building" placeholder="Where was it <?php echo $page_status ?>?" value="<?php echo $_POST['building']; ?>"/>
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
        <textarea name="description" form="form" placeholder="Description" style="resize: vertical;" ><?php echo $_POST['description']; ?></textarea>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" name='search' value="Search"/>
        <input type="submit" name='report' value="Report <?php echo ucwords($page_status) ?>"/>
      </td>
    </tr>
  </table>
  </form>

<?php
  # If the user submitted a search action, generate the search table here
	if (isset($_POST['search'])) {
		$identifier = $_POST['search'];
		echo "<table id='resultsTable'>";
		echo '<tr><th>Item</th>';
		echo '<th>' . ucwords($person) . '</th>';
		echo '<th>Phone</th>';
		echo '<th>Email</th>';
		# Location name listed under 'name' in the query
		echo '<th>Building</th>';
		echo '<th>Room</th>';
		echo '<th>Description</th></tr>';
    # Search the database with the specified fields
		$array = search_item($dbc, $_POST, $page_status);	
		foreach($array as $item) {
			echo '<tr><td><a href=item.php?id=' . $item['item_id'] .'>' . $item['item'] . '</a></td>';
			# Location name listed under 'name' in the query
			echo '<td>' . $item[$person] . '</td>';
			echo '<td>' . $item['phone'] . '</td>';
			echo '<td>' . $item['email'] . '</td>';
			echo '<td>' . $item['name'] . '</td>';
			echo '<td>' . $item['room'] . '</td>';
			echo '<td>' . $item['description'] . '</td></tr>';
		}
		echo "</table>";
	} elseif (isset($_POST['report'])) {
		echo "<div style='margin-left:5em'>";
		foreach($errors as $e) {
			echo $e;
		}
		echo '</div>';
	}
?>



</div>


<?php include 'footer.php' ?>
</body>
