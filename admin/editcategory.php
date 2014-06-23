<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$tsql = 'UPDATE 387732_phpbook1.category SET category_name= "' .$_REQUEST["CategoryName"].'", category_template="' .$_REQUEST["CategoryParent"]. '" where category_id='.$_REQUEST["categoryid"];
$stmt = mysql_query($tsql);

if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{

	
	/* Redirect to original page */
    header('Location:../admin/categories.php');
		
	
}
?>