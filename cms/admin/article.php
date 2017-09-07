<?php            
require_once('../config.php');  // Functions
$cms                = new CMS($database_config);
$userManager    = $cms->getUserManager();
$logged_in = $userManager->is_admin();


include('includes/admin-header.php'); 
?>
<h2>Articles</h2>
<?php
 
  include('includes/admin-footer.php');
?>