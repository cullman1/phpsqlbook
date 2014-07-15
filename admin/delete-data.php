<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$delete_article_sql = 'delete FROM article where article_id='.$_REQUEST["article_id"];
$delete_article_result = $dbHost->query($delete_article_sql);
if(!$delete_article_result) { die("Query failed: ". mysql_error()); }
else
{
    /* Redirect to original page */
    header('Location:../admin/pages.php?deleted=true');
}
?>