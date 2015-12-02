<?php

require_once( 'includes/helpers.php.' );

# Determine whether the submitted username and password are in the database
function validate($dbc, $username = '', $password = '') {
	# If either of the fields is blank, return false
	if(empty($username))
		return false;
	if(empty($password))
		return false;

	$username = mysqli_real_escape_string($dbc, $username);
	$password = mysqli_real_escape_string($dbc, $password);
	$password_hash = hash('sha256', $password);
	$query = "SELECT * FROM users WHERE username = '$username' AND pass = '$password_hash'";

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

function change_password($arg_username, $arg_current_pass, $arg_new_pass, $arg_confirm_pass) {
	$username = mysqli_real_escape_string($dbc, $arg_username);
	$current_pass = mysqli_real_escape_string($dbc, $arg_current_pass);
	$new_pass = mysqli_real_escape_string($dbc, $arg_new_pass);
	$confirm_pass = mysqli_real_escape_string($dbc, $arg_confirm_pass);

	$current_hash = hash('sha256', $current_pass);
	$new_hash = hash('sha256', $new_pass);
	$confirm_hash = hash('sha256', $current_pass);

	if ($new_hash != $confirm_hash)
		return false;
	
	$query = "SELECT * FROM users WHERE username = '$username' AND pass = '$current_hash'";

	return false;
}

?>
