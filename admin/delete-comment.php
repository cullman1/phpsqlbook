<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$delete_comment_sql = 'Update comments set comment="This comment has been removed." where comments_id='.$_REQUEST["comments_id"];
$delete_comment_result = $dbHost->query($delete_comment_sql);
if(!$delete_comment_result) { die("Query failed: ". mysql_error()); }
else
{
    /* Redirect to original page */
    header('Location:../admin/comments.php');
}
?>