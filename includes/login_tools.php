<?php

require( 'includes/helpers.php.' );

function load( $page = 'admin.php', $pid = -1 ) {
  $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname( 'admin/home.php' );

  $url = rtrim($url, '/\\');

  session_start();
  header("Location: $url");

  exit();
}

function validate($username = '', $password = '') {
  global $dbc;

  if(empty($username))
    return -1;
  if(empty($password))
    return -1;
    
  $query = 'SELECT * FROM users WHERE username = $username AND pass = $password';

  $results = mysqli_query($dbc, $query);

  if (mysqli_num_rows($result) == 0)
    return -1;

  $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
  $login_name = $row['username'];

  return $login_name;
}

?>
