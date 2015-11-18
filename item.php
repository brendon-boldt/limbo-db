<?php
require( 'includes/conenct_db.php' );
# Includes these helper functions
require( 'includes/item_helper.php' );

$data = get_item_data($dbc, $_GET['id']);

?>

<head>
<title>Limbo - Item</title>
<link rel="stylesheet" type="text/css" href="limbo.css">
</head>
<?php include 'header.html' ?>
<div id='content'>

<h1><?php echo $data['description'] ?></h1>

</div>
<?php include 'footer.html' ?>
