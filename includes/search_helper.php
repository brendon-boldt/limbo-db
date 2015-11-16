<?php

function search_item($dbc, $values) {
	## Include more search queries
	$query = "SELECT * FROM stuff WHERE item = '" . $values['item'] . "' OR room = '" . $values['room'] . "'";
	### Include check results ###

	$results = mysqli_query($dbc, $query);
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

?>
