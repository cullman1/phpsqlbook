<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB connection
require_once('../includes/class-lib.php');                          // Classes
require_once('../includes/functions.php');                          // Functions
include('includes/admin-header.php'); 
?>

<h2>Media</h2>
<?php
  include('includes/image-gallery.php');
?>
<?php
  include('includes/admin-footer.php');
?>