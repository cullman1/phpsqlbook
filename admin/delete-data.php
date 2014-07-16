<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$delete_article_sql = 'delete FROM article where article_id='.$_REQUEST["article_id"];
$delete_article_result = $dbHost->prepare($delete_article_sql);
$delete_article_result->execute();
if($delete_article_result->errorCode()!=0) {  die("Delete Article Query failed"); }
else
{
    /* Redirect to original page */
    header('Location:../admin/pages.php?deleted=true');
}
?>