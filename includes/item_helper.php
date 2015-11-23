<?php
require_once( 'includes/helpers.php' );
require_once('includes/search_helper.php');

# Get the information related to an item by id
function get_item_data($dbc, $id) {
	$id = mysqli_real_escape_string($dbc, $id);
	$query = "SELECT * FROM stuff WHERE id = $id"; 

	$results = mysqli_query( $dbc , $query ) ;
	check_results($results) ;
	$array = mysqli_fetch_array($results, MYSQLI_ASSOC);
	mysqli_free_result($results);
	return $array;
}

# Insert a lost or found item into the database
function insert_item($dbc, $values, $status) {
	if ($status == 'lost')
		$person = 'owner';
	else
		$person = 'finder';
	# Get the next id for the stuff table
	$id = get_next_id($dbc);

	foreach ($values as $key => $value) {
		# Sanitize the input
		$values[$key] = mysqli_real_escape_string($dbc, $value);
	}

	# Get the location id by name
	$building = mysqli_real_escape_string($dbc, $id);
	$location_id = get_location_id($dbc, $values['building']);
	$person_value = $values[$person];
	$valueString = "($id, '$values[item]', '$person_value', '$values[phone]', '$values[email]', $location_id, '$values[room]', '$values[description]', NOW(), NOW(), '$status')";
	$query = "INSERT INTO stuff(id, item, $person, phone, email, location_id, room, description, create_date, update_date, status) VALUES " . $valueString;
	
	$results = mysqli_query($dbc,$query);
	check_results($dbc, $results) ;
	#mysqli_free_result($results)
	if (!$results)
		return false;
	else {
    # If succesfful, return the id of the newly inserted item
		return $id;
	}
}

# Get the next id in the stuff table
function get_next_id($dbc) {
	$query = "SELECT id FROM stuff ORDER BY id DESC";
	$results = mysqli_query($dbc, $query);
	if (!$results)
		return 0;
	$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
  # Return the id one greater than the highest in the table
	return $row['id'] + 1;
}

# Check that all required fields are filled
function validate_values($dbc, $values) {
	$errors = array();

	if (empty($values['item']))
		$errors[] = "<li>Item cannot be empty";
	if (empty($values['owner']) && empty($values['finder']))
		$errors[] = "<li>Name cannot be empty";
	if (get_location_id($dbc, $values['building']) == -1)
		$errors[] = "<li>No matching location found";
	if (empty($values['description']))
		$errors[] = "<li>Description cannot be empty";
	
	if (empty($errors))
		return 0;
	return $errors;
}

# Perform an admin action; change the status of an item or delete the item
function perform_action($dbc, $id, $action) {
	if ($action == 'delete') {
		$query = "DELETE FROM stuff WHERE id = $id";
	} elseif ($action == 'found') {
		$query = "UPDATE stuff SET status = 'found' WHERE id = $id";
	} elseif ($action == 'lost') {
		$query = "UPDATE stuff SET status = 'lost' WHERE id = $id";
	} else {
		return false;
	}

	$result = mysqli_query($dbc, $query);
	check_results($result);
	return $result;
}

?>
