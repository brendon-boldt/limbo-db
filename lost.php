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

		$item = $_POST['item'];
		$name = $_POST['name'];
		$location= $_POST['location'];
		$room = $_POST['room'];
		$description = $_POST['description'];

		$result = insert_lost_item($dbc, $item, $name, $location, $room, $description);
		#echo "<p>Added " . $result . " new print(s) ". $name . " @ $" . $price . " .</p>" ;
		mysqli_close( $dbc ) ;
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
  <h1>Limbo - Found</h1>
  <form id='lostForm' action='lost.php' method='POST'>
  <table id="formTable">
    <tr>
      <td>
        Item
      </td>
      <td>
        <input type="text" name="item" placeholder="What is the item?"/ required>
      </td>
    </tr>
    <tr>
      <td>
        Name 
      </td>
      <td>
        <input type="text" name="name" placeholder="Who found the item?"/ required>
      </td>
    </tr>
    <tr>
      <td>
        Location
      </td>
      <td>
        <input type="text" name="location" placeholder="Where did you find it?"/ required>
      </td>
    </tr>
    <tr>
      <td>
        Room 
      </td>
      <td>
        <input type="text" name="room" placeholder="Which room was it in?"/ required>
      </td>
    </tr>
    <!--
    <tr>
      <td>
        Date
      </td>
      <td>
        <input type="text" name="date" placeholder="When did you find it?" required/>
      </td>
    </tr>
    -->

    <tr>
      <td>
        Description
      </td>
      <td>
        <textarea name="description" form="lostForm" style="resize: vertical;"></textarea>
      </td>
    </tr>

    <tr>
      <td>
      </td>
      <td>
        <input type="submit" name='search' value="Search"/>
        <input type="submit" name='report_found' value="Report Found"/>
      </td>
    </tr>
  </table>
  </form>

<table id='resultsTable'>
<?php
	if (isset($_POST['search'])) {
		$array = search_item($dbc, $_POST);	
		foreach($array as $item) {
			echo '<tr><td>' . $item['item'] . '</td>';
			echo '<td>' . $item['location_id'] . '</td>';
			echo '<td>' . $item['room'] . '</td>';
			echo '<td>' . $item['description'] . '</td></tr>';
		}
	}
	mysqli_close( $dbc ) ;
?>
</table>



</div>


<?php include 'footer.html' ?>
</body>
</html>
