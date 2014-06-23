<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Include passwords and login details */
require_once('../includes/loginvariables.php');
  
/* Connect using MySql Authentication. */
$conn = mysql_connect( $serverName, $userName, $password);
if(!$conn)
{
        die("Unable to connect. Error: " . mysql_error());
}
  
/* Select db */
mysql_select_db($databaseName) or die ("Couldn't select db. Error:"  . mysql_error()); 
 
session_start();
$commentid=0;
if (isset($_REQUEST["commentid"]))
{
	$commentid = $_REQUEST["commentid"];
}
$articleid =0;
if (isset($_REQUEST["articleid2"]))
{
	$articleid = $_REQUEST["articleid2"];
}
else
{
$articleid  = $_REQUEST["articleid"];
}



/* Query SQL Server for inserting data. */
$tsql = "INSERT INTO comments (comment, article_id, user_id, comment_date, comment_repliedto_id) VALUES ('".$_REQUEST['commentText']."', '".$articleid."', '".$_SESSION['authenticated']."', '". date("Y-m-d H:i:s") ."', '".$commentid."')";

$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    echo  $_REQUEST['commentText']." - ".$articleid." -  ".$_SESSION["authenticated"];
    die("Query failed: ". mysql_error());
}
else
{
  	/* Redirect to original page */
    header('Location:../pages/mainsite.php?submitted=true&page='.$_REQUEST['page']);
}
?>