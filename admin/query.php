<?php
require_once('../includes/connect_db.php');
session_start();
if (!isset($_SESSION['username']) && is_super($dbc, $_SESSION['username'])) {
	Header("Location: /admin.php");
	die;
}
?>
<head>
<title>Limbo - Query</title>
<link rel="stylesheet" type="text/css" href="/limbo.css">
</head>
<?php include '../header.php' ?>

<div id='content'>

<h1>SQL Query</h1>

<form id='form' action='/admin/query.php' method='POST'>
	<textarea name="query" form="form" rows=10 cols=100 placeholder="Type SQL here" ></textarea><br>
	<input type="submit" name='submit' value="Submit SQL"/>
</form>

<h2>Output</h2>
<?php
require_once('../includes/helpers.php');
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	$query = trim($_POST['query'], ';');
	$result = mysqli_query($dbc, $query);
	# DDL commands and most DML (UPDATE, DELETE, ALTER)
	# return true if the query succeds
	if ($result === true) {
		echo 'Query executed successfully.';
	# If the query failed, it will have returned false
	} elseif ($result === false) {
		echo 'Query failed with the follwing message<br>';
		check_results($result);
	# If it is neither of these, we have the iterator
	# for the results of SELECT query
	} else {
		echo '<table id="queryTable">';
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if ($row != false) {
			echo '<tr>';
			# Print the column names by using the associative
			# array keys from the first row
			foreach($row as $key => $item) {
				echo "<th>$key</th>";	
			}
			echo '</tr>';
			# Reset the iterator back to the first result
			mysqli_data_seek($result, 0);
			
			# Print the actual results
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				echo '<tr>';
				foreach($row as $item) {
					echo "<td>$item</td>";	
				}
				echo '</tr>';
			}
		}
		echo '</table>';
		echo "<div style='clear:both'></div>";
	}


}

?>



<br><br><br> <br><br><br>
<a href='/'>Back</a>
</div>
<?php include '../footer.php' ?>
