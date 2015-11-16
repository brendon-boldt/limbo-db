<?php
$debug = true;
#Alex Goncalves and Brendon Boldt

# Shows the records in prints
function show_records($dbc) {
	# Create a query to get the name and price sorted by price
	$query = 'SELECT number, fname, lname FROM presidents ORDER BY number ASC' ;

	# Execute the query
	$results = mysqli_query( $dbc , $query ) ;
	check_results($results) ;

	# Show results
	if( $results )
	{
  		# But...wait until we know the query succeed before
  		# rendering the table start.
  		echo '<H1>Presidents</H1>' ;
  		echo '<TABLE>';
  		echo '<TR>';
  		echo '<TH>Number</TH>';
  		echo '<TH>First Name</TH>';
	        echo '<TH>Last Name</TH>';
  		echo '</TR>';

  		# For each row result, generate a table row
  		while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		{
    		echo '<TR>' ;
    		echo '<TD>' . $row['number'] . '</TD>' ;
    		echo '<TD>' . $row['fname'] . '</TD>' ;
    		echo '<TD>' . $row['lname'] . '</TD>' ;
    		echo '</TR>' ;
  		}

  		# End the table
  		echo '</TABLE>';

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	}
} 

#Show the records in linkypresidents and provides links to president details
function show_link_records($dbc) {
	# Create a query to get the id and last name
	$query = 'SELECT id, lname FROM presidents ORDER BY number ASC' ;

	# Execute the query
	$results = mysqli_query( $dbc , $query) ;
	check_results($results) ;

	# Show results
	if( $results )
	{
  		# But...wait until we know the query succeed before
  		# rendering the table start.
  		echo '<H1>Presidents</H1>' ;
  		echo '<TABLE>';
  		echo '<TR>';
  		echo '<TH>Number</TH>';
  		echo '<TH>Last Name</TH>';
      echo '<TH>ID</TH>';
  		echo '</TR>';

  		# For each row result, generate a table row
  		while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		{
    		echo '<TR>' ;
    		echo '<TD>' . $row['id'] . '</TD>' ;
    		echo '<TD>' . $row['lname'] . '</TD>' ;
    		
    		$alink = '<A HREF=linkypresidents.php?id=' . $row['id'] . '>' . $row['id'] . '</A>' ;
        echo '<TD ALIGN=right>' . $alink . '</TD>' ;
    		echo '</TR>' ;
  		}
  		  
  		# End the table
  		echo '</TABLE>';

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	}
}

#Shows a record when selected
function show_record ($dbc, $id) {
	# Create a query to get the name and price sorted by price
	$query = 'SELECT id, lname, fname FROM presidents WHERE id = ' . $id ;

	# Execute the query
	$results = mysqli_query( $dbc , $query) ;
	check_results($results) ;

	# Show results
	if( $results )
	{
  		# But...wait until we know the query succeed before
  		# rendering the table start.
  		echo '<H1>Presidents</H1>' ;
  		echo '<TABLE>';
  		echo '<TR>';
  		echo '<TH>ID</TH>';
  		echo '<TH>First Name</TH>';
      echo '<TH>Last Name</TH>';
  		echo '</TR>';

  		# For each row result, generate a table row
  		while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		{
    		echo '<TR>' ;
    		echo '<TD>' . $row['id'] . '</TD>' ;
    		echo '<TD>' . $row['fname'] . '</TD>' ;
    		echo '<TD>' . $row['lname'] . '</TD>' ;
    		echo '</TR>' ;
  		}

  		# End the table
  		echo '</TABLE>';

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	}
} 

# Inserts a record into the presidents table

# Shows the query as a debugging aid
function show_query($query) {
  global $debug;

  if(false && $debug)
    echo "<p>Query = $query</p>" ;
}

# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;

  if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>'  ;


}

function valid_number($num){
  if (intval($num) <= 0) {
    return false;
  }
  return is_numeric($num);
}

function valid_name($name){
  return !empty($name);
}
?>
