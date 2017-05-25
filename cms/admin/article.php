<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('includes/functions.php');                          // Functions

include('includes/admin-header.php'); 
?>
<h2>Articles</h2>
<?php
  include('includes/list-articles.php'); 
  include('includes/admin-footer.php');
?>