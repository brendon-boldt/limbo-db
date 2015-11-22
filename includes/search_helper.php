<?php
require_once('includes/helpers.php');

# Search for an item based on field values
function search_item($dbc, $values, $status) {
	$location_id = get_location_id($dbc, $values['building']);	

	# '~~~' is a string which will not match anything in the database
	foreach ($values as $key => $value) {
		if ($value == "")
			$values[$key] = "~~~";
		else
      # Sanitize the input
			$values[$key] = mysqli_real_escape_string($dbc, $value);
	}
  # More non-matching stings
	if (!array_key_exists('owner', $values))
		$values['owner'] = '~~~';	
	if (!array_key_exists('finder', $values))
		$values['finder'] = '~~~';	

  # Build the behemoth of a query
	$query = "SELECT *, stuff.id AS item_id FROM stuff JOIN locations ON (stuff.location_id = locations.id)
		WHERE (item LIKE '%$values[item]%' 
		OR owner LIKE '%$values[owner]%'
		OR finder LIKE '%$values[finder]%'
		OR email LIKE '%$values[email]%'
		OR phone LIKE '%$values[phone]%'
		OR room LIKE '%$values[room]%'
		OR description LIKE '%$values[description]%'
		OR location_id = '$location_id')
		AND status = '$status'";

	$results = mysqli_query($dbc, $query);
	check_results($results);
	if ($results != true) {
		echo mysqli_error($dbc);
		exit();
	}

  # Build an array of row results to be returned by the function
	$array = array();
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$array[] = $row;
	}
	mysqli_free_result($results);

	return $array;
}

# Get item information based on the id given
function search_item_by_id($dbc, $id) {
	$query = "SELECT * FROM stuff WHERE id = $id";
	$results = mysqli_query($dbc, $query);
	check_results($results);
	if ($results != true) {
		echo mysqli_error($dbc);
		exit();
	}

	if (!($row = mysqli_fetch_array($results, MYSQLI_ASSOC))) {
		return -1;
	}
	mysqli_free_result($results);

	return $row;

}

# Search for location and return its id based ona given name (keyword search)
function get_location_id($dbc, $name) {
	if (empty($name))
		return -1;
	else
		$name = mysqli_real_escape_string($dbc, $name);
	$query = "SELECT id FROM locations WHERE name LIKE '%$name%'";
	$results = mysqli_query($dbc, $query);
	check_results($results);
	# If no locations matched, return -1
	if (!($row = mysqli_fetch_array($results, MYSQLI_ASSOC)))
		return -1;
	mysqli_free_result($results);

	return $row['id'];
}

# Get the name of location based on the id given
function get_location_name($dbc, $id) {
	if (empty($id))
		return '';
	$query = "SELECT name FROM locations WHERE id = $id";
	$result = mysqli_query($dbc, $query);
	check_results($result);
	if (!($row = mysqli_fetch_array($result, MYSQLI_ASSOC)))
		return '';
	mysqli_free_result($result);

	return $row['name'];
}

# Prints the most recently updated items on the home page
function index_queries($dbc){
	#Make the query I want to execute
	$limit_stopper = 0;
	$query = "SELECT *, stuff.id AS item_id FROM stuff JOIN locations ON (locations.id = stuff.location_id) ORDER BY stuff.update_date DESC";
	#Executes the query I requested
	$results = mysqli_query($dbc, $query);
	check_results($results);
  
	#Show the results of the execution
	 if($results){
		 #Generating the table information
		 echo '<H1>Recently updated in Limbo</H1>' ;
		 echo '<TABLE id="indexTable" style="margin-left:80px; border: solid;">';
		 echo '<TR>';
		 echo '<TH>Name</TH>';
		 echo '<TH>Status</TH>';
		 echo '<TH>Location</TH>';
		 echo '</TR>';
		 
		#Generate the table row
		while($limit_stopper < 5 && $row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		{	
		echo '<TR>';
		echo "<td> <a href='item.php?id=$row[item_id]'>$row[item]</a> </td>";
		echo '<TD>' . ucwords($row['status']) . '</TD>' ;
		echo '<TD>' . $row['name'] . '</TD>' ;
		echo '</TR>';
		$limit_stopper++;
		}
		#Thus concludes the table
		echo '</TABLE>';
		
		# Free memory
		mysqli_free_result($results);
	}
}
?>
