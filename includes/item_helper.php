<?php
require( 'includes/helpers.php' );

function get_item_data($dbc, $id) {
  global $dbc;

  $query = "SELECT * FROM stuff WHERE id = $id"; 

  $results = mysqli_query( $dbc , $query ) ;
  check_results($results) ;
  return mysqli_fetch_array($results, MYSQLI_ASSOC);
}

?>
