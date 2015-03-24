<?php

/* Include passwords and login details */
session_start();

// Unset all of the session variables.
$_SESSION = array();

setcookie(session_name(),'', time()-3600, '/');

// Finally, destroy the session.
session_destroy();

/* Redirect */
header('Location:../chapter6/commenting.php');

?>