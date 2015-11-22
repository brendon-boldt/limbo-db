<?php
require_once( 'includes/helpers.php' );
require_once('includes/search_helper.php');

function get_item_data($dbc, $id) {
		global $dbc;

		$query = "SELECT * FROM stuff WHERE id = $id"; 

		$results = mysqli_query( $dbc , $query ) ;
		check_results($results) ;
		$array = mysqli_fetch_array($results, MYSQLI_ASSOC);
		mysqli_free_result($results);
		return $array;
}

function insert_item($dbc, $values, $status) {
	if ($status == 'lost')
		$person = 'owner';
	else
		$person = 'finder';
	$id = get_next_id($dbc);

	$location_id = get_location_id($dbc, $values['building']);
	$valueString = "($id, '$values[item]', '$values[owner]', '$values[phone]', '$values[email]', $location_id, '$values[room]', '$values[description]', NOW(), NOW(), '$status')";
	$query = "INSERT INTO stuff(id, item, $person, phone, email, location_id, room, description, create_date, update_date, status) VALUES " . $valueString;
	
	$results = mysqli_query($dbc,$query);
	check_results($dbc, $results) ;
	#mysqli_free_result($results)
	if (!$results)
		return false;
	else {
		return $id;
	}
}

function get_next_id($dbc) {
	$query = "SELECT id FROM stuff ORDER BY id DESC";
	$results = mysqli_query($dbc, $query);
	if (!$results)
		return 0;
	$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
	return $row['id'] + 1;
}

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
