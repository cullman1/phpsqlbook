<?php
//require_once('../classes/FileSessionHandler.php');

// Unset all of the session variables.
$_SESSION = array();
setcookie(session_name(),'', time()-3600, '/');
// Finally, destroy the session.
session_destroy();

/* Redirect */
header('Location:../pages/main.php');

?>