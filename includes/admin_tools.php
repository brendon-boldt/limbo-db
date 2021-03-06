<?php

require_once( 'helpers.php.' );

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
	# If the validation succeeded, return the login username
	$login_name = $row['username'];

	return $login_name;
}

# Changes the password for user if the validation passes using the current_pass
function change_password($dbc, $username, $current_pass, $new_pass, $confirm_pass) {
	# Sanitize input
	$username = mysqli_real_escape_string($dbc, $username);
	$new_pass = mysqli_real_escape_string($dbc, $new_pass);
	$confirm_pass = mysqli_real_escape_string($dbc, $confirm_pass);

	$new_hash = hash('sha256', $new_pass);
	$confirm_hash = hash('sha256', $confirm_pass);

	# If the passwords do not match, no need to go further
	if ($new_hash != $confirm_hash)
		return "Passwords did not match";

	$validationResult = validate($dbc, $username, $current_pass);
	if ($validationResult == false) {
		return "Current password incorrect";
	}
	
	$updateQuery = "UPDATE users SET pass = '$new_hash' WHERE username = '$username'";

	$results = mysqli_query($dbc, $updateQuery);
	check_results($results);

	# If the query failed or there were no matches, return false	
	if ($results !== true) 
		return "Password update failed";

	return "Password update successful";
}

# Changes the email for a user if the current_pass passes validation
function change_email($dbc, $username, $password, $email) {
	$email = mysqli_real_escape_string($dbc, $email);
	$username = mysqli_real_escape_string($dbc, $username);
	$validationResult = validate($dbc, $username, $password);
	if ($validationResult == false) {
		return "Current password incorrect";
	}
	
	$query = "UPDATE users SET email = '$email' WHERE username = '$username'";
	$results = mysqli_query($dbc, $query);
	check_results($results);

	# If the query failed or there were no matches, return false	
	if ($results !== true) 
		return "Email update failed";

	return "Email update successful";
}

# Returns true if the current user is a super admin
function is_super($dbc, $username) {
	$query = "SELECT * FROM users WHERE username = '$username' AND super_admin = true";

	$result = mysqli_query($dbc, $query);
	check_results($result);

	if ($result == false) 
		return false;
	if (mysqli_num_rows($result) == 0)
		return false;

	return true;
}

# Adds a user with the specified username
function add_admin($dbc, $username, $new_admin) {
	$username = mysqli_real_escape_string($dbc, $username);
	$new_admin = mysqli_real_escape_string($dbc, $new_admin);


	$limbo_hash = hash('sha256', 'limbo');

	# Only super admins may create users
	if (!is_super($dbc, $username))
		return "Current user is not a super administrator";

	# Adds admin with a default password of 'limbo' and as a non-super admin
	$query = "INSERT INTO users (username, pass, super_admin) VALUES ('$new_admin', '$limbo_hash', false)";

	$result = mysqli_query($dbc, $query);
	check_results($result);

	if ($result !== true) 
		return "Administrator creation failed";

	return "Administrator: '$new_admin' successfully created (default password is 'limbo')";
}

# Deletes the user with the given username
function delete_admin($dbc, $username, $target_admin) {
	$username = mysqli_real_escape_string($dbc, $username);
	$target_admin = mysqli_real_escape_string($dbc, $target_admin);

	# Only super admins may delete users
	if (!is_super($dbc, $username))
		return "Current user is not a super administrator";


	$query = "DELETE FROM users WHERE username = '$target_admin'";

	$result = mysqli_query($dbc, $query);
	check_results($result);

	if ($result !== true) 
		return "Administrator deletion failed";

	return "Administrator: '$target_admin' successfully deleted";
}

?>
