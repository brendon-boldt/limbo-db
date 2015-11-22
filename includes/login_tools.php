<?php

require_once( 'includes/helpers.php.' );

# Determine whether the submitted username and password are in the database
function validate($dbc, $username = '', $password = '') {
  # If either of the fields is blank, return false
	if(empty($username))
		return false;
	if(empty($password))
		return false;

	$query = "SELECT * FROM users WHERE username = '$username' AND pass = '$password'";

	$results = mysqli_query($dbc, $query);
	check_results($results);

  # If the query failed or there were no matches, return false	
	if ($results == false) 
		return false;
	if (mysqli_num_rows($results) == 0)
		return false;

	$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
  /*
	foreach($row as $value)
		echo $value . "<br>";
   */
  # If the validation succeeded, return the login username
	$login_name = $row['username'];

	return $login_name;
}

?>
