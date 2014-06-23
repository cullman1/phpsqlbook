<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');


$date =  date("Y/m/d, h:i:s");

if($_REQUEST["articlecontent"]!="")
{
	$date= date("Y/m/d, h:i:s", strtotime($_REQUEST["articlecontent"]));	
}


/* Query */
$tsql = "update article set date_published = '".$date."' WHERE article_id=".$_REQUEST["articleid"];

$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{

		/* Redirect to original page */
    header('Location:../admin/pages.php');
}
?>