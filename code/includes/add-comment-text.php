<?php 
require_once('../includes/db_config.php');

session_start();

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
$insert_comment_sql = "INSERT INTO comments (comment, article_id, user_id, comment_date) VALUES ('".$_REQUEST['commentText']."', '".$articleid."', '".$_SESSION['authenticated']."', '". date("Y-m-d H:i:s") ."')";
$insert_comment_result = $dbHost->prepare($insert_comment_sql);
$insert_comment_result->execute();
if($insert_comment_result->errorCode()!=0) {  die("Insert Comments Query failed"); }
else
{
    /* Redirect to original page */
    header('Location:../chapter6/commenting.php?submitted=true&page='.$_REQUEST['page']);
}
?>