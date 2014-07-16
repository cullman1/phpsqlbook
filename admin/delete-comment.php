<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$delete_comment_sql = 'Update comments set comment="This comment has been removed." where comments_id='.$_REQUEST["comments_id"];
$delete_comment_result = $dbHost->prepare($delete_comment_sql);
$delete_comment_result->execute();
if($delete_comment_result->errorCode()!=0) {  die("Update Comments Query failed"); }

else
{
    /* Redirect to original page */
    header('Location:../admin/comments.php');
}
?>