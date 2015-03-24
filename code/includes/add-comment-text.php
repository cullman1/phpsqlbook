<?php 
require_once('../includes/db_config.php');
require_once('../classes/user.php');
session_start();
$commentid=0;
if (isset($_REQUEST["commentid"]))
{
	$commentid = $_REQUEST["commentid"];
}

$articleid  = $_REQUEST["articleid"];

$auth="";
if (isset($_SESSION["user2"])) 
{ 
    $so = $_SESSION["user2"];
    $user_object = unserialize($so);
    $auth = $user_object->getAuthenticated();

    /* Query SQL Server for inserting data. */
    $insert_comment_sql = "INSERT INTO comments (comment, article_id, user_id, comment_date, comment_repliedto_id) VALUES ('".$_REQUEST['commentText']."', '".$articleid."', '".$auth."', '". date("Y-m-d H:i:s") ."', '".$commentid."')";
    $insert_comment_result = $dbHost->prepare($insert_comment_sql);
    $insert_comment_result->execute();
    if($insert_comment_result->errorCode()!=0) {  die("Insert Comments Query failed"); }
    else
    {
  	    /* Redirect to original page */
        $return = $_SERVER["HTTP_REFERER"];
        header('Location:'.$return);
    }
}
else
{
    header('Location:../login/login-user.php');
}
?>