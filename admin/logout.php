<?php

# End the session and redirect to the login page
session_start();
session_destroy();
header("Location: /admin.php");

?>
