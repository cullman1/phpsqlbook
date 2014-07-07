<?php 
/* Db Details */
require_once('../includes/db_config.php');

$date =  date("Y/m/d, h:i:s");
if($_REQUEST["articlecontent"]!="")
{
	$date= date("Y/m/d, h:i:s", strtotime($_REQUEST["articlecontent"]));	
}

/* Query to update publish date*/
$update_publishdate_sql = "update article set date_published = '".$date."' WHERE article_id=".$_REQUEST["articleid"];
$update_publishdate_result = mysql_query($update_publishdate_sql);
if(!$update_publishdate_result) {  die("Query failed: ". mysql_error()); } else 
{

		/* Redirect to original page */
    header('Location:../admin/pages.php');
}
?>