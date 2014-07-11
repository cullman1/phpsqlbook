<?php 
require_once('../includes/db_config.php');
 
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
$insert_comment_sql = "INSERT INTO comments (comment, article_id, user_id, comment_date, comment_repliedto_id) VALUES ('".$_REQUEST['commentText']."', '".$articleid."', '".$_SESSION['authenticated']."', '". date("Y-m-d H:i:s") ."', '".$commentid."')";
$insert_comment_result = mysql_query($insert_comment_sql);
if(!$insert_comment_result) {  die("Insert Comment Query failed: ". mysql_error() . " " . $_REQUEST['commentText']." - ".$articleid." -  ".$_SESSION["authenticated"]); }
else
{
  	/* Redirect to original page */
    header('Location:../pages/main.php?submitted=true&page='.$_REQUEST['page']);
}
?>