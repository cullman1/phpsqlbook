<?php
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

if (isset($_REQUEST["publish"]))
{
    /* Query to update article publish date*/
    $update_user_sql = "update user set active = active ^ 1 WHERE user_id=".$_REQUEST["userid"];
    $update_user_result = $dbHost->prepare($update_user_sql);
    $update_user_result->execute();
    if($update_user_result->errorCode()!=0) {  die("Update User Query failed"); }
    else
    {
        /* Redirect to original page */
        $name = $_REQUEST['publish'];
        header('Location:../admin/'.$name.'.php?submitted=missing');
    }
} 
?>