<?php
require('includes/helpers.php');
require('includes/search_helper.php');


function insert_lost_item($dbc, $item, $owner, $location_name, $room , $description) {

	$location_id = $location_name;

	#$valueString = '("' . $item . '","' . $owner . '",' . $location_id . ',"' . $room . '","' . $description . '", NOW(), NOW(), \'lost\')';
	$valueString = "('$item', '$owner', $location_id, '$room', '$description', NOW(), NOW(), 'lost')";
	$query = 'INSERT INTO stuff(item, owner, location_id, room, description, create_date, update_date, status) VALUES ' . $valueString;
	#show_query($query);

	$results = mysqli_query($dbc,$query) ;
	check_results($results) ;

	return $results ;
}

?>
