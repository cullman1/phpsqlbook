<?php  
/* Include passwords and login details */
require_once('../includes/db_config.php');
  
/* Query SQL Server for checking user details. */
$passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);
$select_user_sql = "SELECT Count(*) as CorrectDetails, user_id, full_name from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'" ." AND active= 0";
$select_user_result = $dbHost->query($select_user_sql);
# setting the fetch mode
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);

  	/* Redirect to original page */
while($select_user_row = $select_user_result->fetch())
  	{
        if ($select_user_row["CorrectDetails"]==1)
  	 	{
  	 		session_start();
  	 		/* store user_id */
  	 		$_SESSION['authenticated'] = $select_user_row["user_id"];
            $_SESSION['username'] = $select_user_row["full_name"];
            if(isset($_REQUEST["page"]))
            {
                
                if ($_REQUEST["page"]=="pages")
                {
                    header('Location:../admin/pages.php');
                }
                if ($_REQUEST["page"]=="mainsite")
                {
                    header('Location:../home?showcomments=true');
  	 	        }   
            }
            else
            {
                header('Location:../home');
            }
        }
  	 	else
  	 	{
  	 		/* Incorrect details */
			header('Location:../login/logon.php?login=failed');
  	 	}
    }

?>