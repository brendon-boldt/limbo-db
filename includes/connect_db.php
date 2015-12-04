<?php 
# CONNECT TO MySQL DATABASE.


# Connect  on 'localhost' for user 'mike' with password 'easysteps' to database 'site_db'.

# Otherwise fail gracefully and explain the error. 

$dbc = @mysqli_connect ( 'localhost', 'root', '', 'limbo_db' );


//OR die ( mysqli_connect_error() ) ;

if ($dbc == false) {
	$command = "\"C:\\Program Files (x86)\\EasyPHP-DevServer-14.1VC11\\binaries\\mysql\\bin\\mysql\" -u root < \"C:\\Program Files (x86)\\EasyPHP-DevServer-14.1VC11\\data\\localweb\\includes\limbo.sql\"";
	$output = shell_exec($command);
	$dbc = @mysqli_connect ( 'localhost', 'root', '', 'limbo_db' );
}

# Set encoding to match PHP script encoding.

mysqli_set_charset( $dbc, 'utf8' ) ;
