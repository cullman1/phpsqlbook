<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$update_category_sql = 'UPDATE category SET category_name= "' .$_REQUEST["CategoryName"].'", category_template="' .$_REQUEST["CategoryParent"]. '" where category_id='.$_REQUEST["categoryid"];
$update_category_result = $dbHost->prepare($update_category_sql);
$update_category_result->execute();
if($update_category_result->errorInfo()[1]!=0) {  die("Update Category Query failed: ".$update_category_result->errorInfo()[0]); }
else
{	
	/* Redirect to original page */
    header('Location:../admin/categories.php');	
}
?>