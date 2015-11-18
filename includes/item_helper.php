<?php
require( 'includes/helpers.php' );

function get_item_data($dbc, $id) {
  global $dbc;

  $query = "SELECT * FROM stuff WHERE id = $id"; 

  $results = mysqli_query( $dbc , $query ) ;
  check_results($results) ;
  $array = mysqli_fetch_array($results, MYSQLI_ASSOC);
  mysqli_free_result($results);
  return $array;
}

?>
