<?php
require_once('includes/helpers.php');

# Add status checking
function search_item($dbc, $values) {
	$location_id = get_location_id($dbc, $values['location']);	

	foreach ($values as $key => $value) {
		if ($value == "")
			$values[$key] = "~~~";
	}
	$query = "SELECT * FROM stuff JOIN locations ON (stuff.location_id = locations.id)
		WHERE item LIKE '%" . $values['item'] . "%' 
		OR room LIKE '%" . $values['room'] . "%'
		OR description LIKE '%" . $values['description'] . "%'
		OR location_id = '" . $location_id . "'";

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
	if (empty($name))
		return -1;
	$query = "SELECT id FROM locations WHERE name LIKE '%$name%'";
	$results = mysqli_query($dbc, $query);
	check_results($results);
	# If no locations matched, return -1
	if (!($row = mysqli_fetch_array($results, MYSQLI_ASSOC)))
		return -1;
	mysqli_free_result($results);

	return $row['id'];
}

function index_queries($dbc){
	#Make the query I want to execute
	$limit_stopper = 1;
	$query = "SELECT stuff.item, stuff.status, locations.name FROM stuff JOIN locations ON (locations.id = stuff.location_id) ORDER BY stuff.create_date DESC";
	#Executes the query I requested
	$results = mysqli_query($dbc, $query);
	check_results($results);
  
	#Show the results of the execution
	 if($results){
		 #Generating the table information
		 echo '<H1>" RECENTLY IN LIMBO..." </H1>' ;
		 echo '<TABLE style="margin-left:80px" border="1" length="2" width="2">';
		 echo '<TR>';
		 echo '<TH>Name</TH>';
		 echo '<TH>Status</TH>';
		 echo '<TH>Location</TH>';
		 echo '</TR>';
		 
		#Generate the table row
		while($limit_stopper <= 5 && $row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		{	
		echo '<TR>';
		echo '<TD>' . $row['item'] . '</TD>' ;
		echo '<TD>' . $row['status'] . '</TD>' ;
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
