<?php  
/* Include passwords and login details */
require_once('../includes/dbconfig.php');
  
/* Query SQL Server for checking user details. */
$passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);
$select_user_sql = "SELECT Count(*) as CorrectDetails, user_id, user_name from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'";
$select_user_result = mysql_query($select_user_sql);
if(!$select_user_result) {  die("Query failed: ". mysql_error()); }
else
{
  	/* Redirect to original page */
    while($select_user_row = mysql_fetch_array($select_user_result))
  	{
        if ($select_user_row["CorrectDetails"]==1)
  	 	{
  	 		session_start();
  	 		/* store user_id */
  	 		$_SESSION['authenticated'] = $select_user_row["user_id"];
            $_SESSION['username'] = $select_user_row["user_name"];
  	 		
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
}
?>