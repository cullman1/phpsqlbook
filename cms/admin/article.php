<?php            
require_once('../config.php');  // Functions

$logged_in = $userManager->redirectNonAdmin();

include('includes/admin-header.php'); 
?>
<h2>Articles</h2>
<?php
 
  include('includes/admin-footer.php');
?>