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
        $select_role_sql = "select * from role where role = ".$_REQUEST['publish'];
        $select_role_result = $dbHost->prepare($select_role_sql);
        $select_role_result->execute();
        while($select_role_row = $select_role_result->fetch()) 
        { 
            $name = $select_role_row["role_name"];
            header('Location:../admin/'.$name.'.php?submitted=missing');
        }
    }
} 
?>