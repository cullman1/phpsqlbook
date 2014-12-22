<?php
require_once('../classes/FileSessionHandler.php');

// Unset all of the session variables.
$_SESSION = array();

// Finally, destroy the session.
session_destroy();

/* Redirect */
header('Location:../pages/main.php');

?>