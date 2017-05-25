<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('../includes/functions.php');                          // Classes

include('includes/admin-header.php'); 
?>

<h2>Users</h2>
<?php
  include('includes/list-user.php');
?>

<?php
  include('includes/admin-footer.php');
?>