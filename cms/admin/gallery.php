<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB connection
require_once('includes/functions.php');                          // Classes
require_once('includes/class-lib.php');                          // Classes

include('includes/admin-header.php'); 
?>

<h2>Categories</h2>

<?php
  include('includes/list-galleries.php'); 
  include('includes/admin-footer.php');
?>