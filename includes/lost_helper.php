<?php
require_once('includes/helpers.php');
require_once('includes/search_helper.php');


function insert_lost_item($dbc, $values) {

	$location_id = get_location_id($dbc, $values['building']);
	$valueString = "('$values[item]', '$values[owner]', '$values[phone]', '$values[email]', $location_id, '$values[room]', '$values[description]', NOW(), NOW(), 'lost')";
	$query = 'INSERT INTO stuff(item, owner, phone, email, location_id, room, description, create_date, update_date, status) VALUES ' . $valueString;
	
	$results = mysqli_query($dbc,$query);
	check_results($results) ;
	#mysqli_free_result($results)
	if (!$results)
		return false;
	else {
		/*
		mysqli_query($dbc, "SELECT id FROM stuff WHERE item = $values[item]");
		$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
		return $row['id'];
		*/
		return true;
	}
}

?>
