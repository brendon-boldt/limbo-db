<?php

require_once( 'includes/helpers.php.' );

/*
function load( $page = 'admin.php', $pid = -1 ) {
  $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname( 'admin/home.php' );

  $url = rtrim($url, '/\\');

  session_start();
  header("Location: $url");

  exit();
}
*/

function validate($dbc, $username = '', $password = '') {
	if(empty($username))
		return false;
	if(empty($password))
		return false;

	$query = "SELECT * FROM users WHERE username = '$username' AND pass = '$password'";

	$results = mysqli_query($dbc, $query);
	check_results($results);

	
	if ($results == false) 
		return false;
	if (mysqli_num_rows($results) == 0)
		return false;

	$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
	foreach($row as $value)
		echo $value . "<br>";
	$login_name = $row['username'];

	return $login_name;
}

?>
