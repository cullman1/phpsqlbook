<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$tsql = 'delete FROM 387732_phpbook1.article where article_id='.$_REQUEST["article_id"];
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{

		/* Redirect to original page */
    header('Location:../admin/pages.php?deleted=true');
}
?>