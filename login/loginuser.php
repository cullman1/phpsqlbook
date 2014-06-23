<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Include passwords and login details */
require_once('../includes/loginvariables.php');
  
/* Connect using MySql Authentication. */
$conn = mysql_connect( $serverName, $userName, $password);
if(!$conn)
{
        die("Unable to connect. Error: " . mysql_error());
}
  
/* Select db */
mysql_select_db($databaseName) or die ("Couldn't select db. Error:"  . mysql_error()); 
  
/* Query SQL Server for checking user details. */
$passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);
$tsql = "SELECT Count(*) as CorrectDetails, user_id, user_name from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{
  	/* Redirect to original page */
  	while($row = mysql_fetch_array($stmt))
  	{
  	 	if ($row["CorrectDetails"]==1)
  	 	{
  	 		session_start();
  	 		/* store user_id */
  	 		$_SESSION['authenticated'] = $row["user_id"];
        $_SESSION['username'] = $row["user_name"];
  	 		
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