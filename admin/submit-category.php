<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$update_category_sql = 'UPDATE category SET category_name= "' .$_REQUEST["CategoryName"].'", category_template="' .$_REQUEST["CategoryParent"]. '" where category_id='.$_REQUEST["categoryid"];
$update_category_result = mysql_query($update_category_sql);
if(!$update_category_result) {  die("Query failed: ". mysql_error()); }
else
{	
	/* Redirect to original page */
    header('Location:../admin/categories.php');	
}
?>