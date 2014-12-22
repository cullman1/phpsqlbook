<?php

/* Include passwords and login details */
session_start();

// Unset all of the session variables.
$_SESSION = array();

// Finally, destroy the session.
session_destroy();

/* Redirect */
header('Location:../pages/main.php');

?>