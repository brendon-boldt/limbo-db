<?php
session_start();
require('includes/search_helper.php'); 
require('includes/connect_db.php'); 
	  
?>
<head>
<title>Limbo</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
<script src="jquery.js"></script>
</head>
<body>

<?php include 'header.php' ?>

<div id="content">
  <h1>Welcome to Limbo</h1>
  <br>
  <h4> If you have recently lost or found an item at Marist College, then this is the database for you! </h4>
  <br>
  <?php
  	index_queries($dbc);
  ?>
</div>

<?php include 'footer.php' ?>

</div>
</body>
