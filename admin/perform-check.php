<?php 
/* Include passwords and login details */
require_once('../includes/db_config.php');

if (empty($_REQUEST['emailAddress']) )
{
	/* No email supplied */
     
}
else
{
    /* Query SQL Server for checking existing user. */
    $select_user_sql = "SELECT * from user WHERE email = '".$_REQUEST['emailAddress']."'";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
    $select_user_rows = $select_user_result->fetchAll();
    $num_rows = count($select_user_rows);
    if($num_rows>0)
    {
        /* Already exists. */
            
    }	
    else
    {
        /* Doesn't exist. */
        
    }
    
}
?>
