<?php
require_once('includes/helpers.php')

function search_item($dbc, $values) {
	## Include more search queries
	$query = "SELECT * FROM stuff WHERE item = '" . $values['item'] . "' OR room = '" . $values['room'] . "'";

	$results = mysqli_query($dbc, $query);
  check_results($results);
	if ($results != true) {
		echo mysqli_error($dbc);
		exit();
	}

	$array = array();
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$array[] = $row;
	}
	mysqli_free_result($results);

	return $array;
}

function get_location_id($dbc, $name) {
  $query = "SELECT id FROM locations WHERE name LIKE '%$name%'";
  $results = mysqli_query($dbc, $query);
  check_results($results);
  $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
	mysqli_free_result($results);

  # Does this check null's?
  return $row['id'];
}

?>
