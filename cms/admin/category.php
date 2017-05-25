<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB connection
require_once('../includes/functions.php');                          // Classes

include('includes/admin-header.php'); 
?>

<h2>Categories</h2>

<?php
  include('includes/list-categories.php'); 
  include('includes/admin-footer.php');
?>