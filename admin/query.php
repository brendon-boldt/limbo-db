<?php
session_start();
if (!isset($_SESSION['username'])) {
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
require_once('../includes/connect_db.php');
require_once('../includes/helpers.php');
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	$query = trim($_POST['query'], ';');
	$result = mysqli_query($dbc, $query);
	if ($result === true) {
		echo 'Query executed successfully.';
	} elseif ($result === false) {
		echo 'Query failed with the follwing message<br>';
		check_results($result);
	} else {
		//foreach($array as $item) {
		echo '<table id="queryTable">';
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if ($row != false) {
			echo '<tr>';
			foreach($row as $key => $item) {
				echo "<th>$key</th>";	
			}
			echo '</tr>';
			mysqli_data_seek($result, 0);

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
