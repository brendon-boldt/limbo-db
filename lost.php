<html>

<?php
# Connect to MySQL server and the database
require( 'includes/connect_db.php' ) ;

# Includes these helper functions
require( 'includes/lost_helper.php' ) ;
if ($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
    /*
    #Checks if id is set
    if(isset($_GET['id']))
      show_record($dbc, $_GET['id']) ;
    else {
      $num ="";
      $fname ="";
      $lname ="";
    }
    */
}
else if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

	if (isset($_POST['report_found'])) {
		$errors = array();

		/*
		$num = trim($_POST['num']);
		$lname = $_POST['lname'];
		$fname = $_POST['fname'] ;
		if(!valid_number($num))
		$errors[] = 'number';
		if (!valid_name($fname))
		$errors[] = 'first name';
		if (!valid_name($lname))
		$errors[] = 'last name';

		if(!empty($errors)) {
		echo '<p style="color:red; font-size: 16pt">There was an error in the following fields: ';
		foreach ($errors as $field) {
		    echo " - $field";
		}
		} else {
		$result = insert_record($dbc, $num, $lname, $fname) ;
		echo 'Successfully added';
		$_POST['num'] = "";
		$_POST['fname'] = "";
		$_POST['lname'] = "";
		}

		*/

		$values = array();
		$values['item'] = $_POST['item'];
		$values['owner'] = $_POST['owner'];
		$values['phone'] = $_POST['phone'];
		$values['email'] = $_POST['email'];
		$values['building'] = $_POST['building'];
		$values['room'] = $_POST['room'];
		$values['description'] = $_POST['description'];
		$result = insert_lost_item($dbc, $values);
		mysqli_close( $dbc ) ;
		#Header("Location: /item.php?id=$result");
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
        <input type="text" name="item" placeholder="What is the item?"/>
      </td>
    </tr>
    <tr>
      <td>
        Name 
      </td>
      <td>
        <input type="text" name="owner" placeholder="Who found the item?"/>
      </td>
    </tr>
    <tr>
      <td>
        Phone 
      </td>
      <td>
        <input type="text" name="phone" placeholder="Optional"/>
      </td>
    </tr>
    <tr>
      <td>
        Email 
      </td>
      <td>
        <input type="text" name="email" placeholder="Optional"/>
      </td>
    </tr>
    <tr>
      <td>
        Building       
      </td>
      <td>
        <input type="text" name="building" placeholder="Where did you find it?"/>
      </td>
    </tr>
    <tr>
      <td>
        Room 
      </td>
      <td>
        <input type="text" name="room" placeholder="Which room was it in?"/>
      </td>
    </tr>
    <tr>
      <td>
        Description
      </td>
      <td>
        <textarea name="description" form="lostForm" placeholder="Optional" style="resize: vertical;"></textarea>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" name='search' value="Search"/>
        <input type="submit" name='report_found' value="Report Lost"/>
      </td>
    </tr>
  </table>
  </form>

<?php
	if (isset($_POST['search'])) {
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
			echo '<tr><td>' . $item['item'] . '</td>';
			# Location name listed under 'name' in the query
			echo '<td>' . $item['owner'] . '</td>';
			echo '<td>' . $item['phone'] . '</td>';
			echo '<td>' . $item['email'] . '</td>';
			echo '<td>' . $item['name'] . '</td>';
			echo '<td>' . $item['room'] . '</td>';
			echo '<td>' . $item['description'] . '</td></tr>';
		}
		echo "</table>";
		mysqli_close( $dbc );
	}
?>



</div>


<?php include 'footer.html' ?>
</body>
</html>
