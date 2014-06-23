<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Include passwords and login details */
require_once('../includes/loginvariables.php');

if (empty( $_REQUEST['password']) || empty($_REQUEST['firstName']) || empty($_REQUEST['lastName']) || empty($_REQUEST['emailAddress']) )
{
	/* Redirect to original page */
  	$name = $_REQUEST['page'];
  	if($name=="register")
  	{
  		header('Location:../login/'.$name.'.php?submitted=missing');
  	}
  	else
  	{
    	header('Location:new-'.$name.'.php?submitted=missing');
	}
}
else
{

/* Connect using MySql Authentication. */
$conn = mysql_connect( $serverName, $userName, $password);
if(!$conn)
{
        die("Unable to connect. Error: " . mysql_error());
}
  
/* Select db */
mysql_select_db($databaseName) or die ("Couldn't select db. Error:"  . mysql_error()); 
 
/* Hash password */

$passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);

/* Query SQL Server for checking existing user. */
$tsql1 = "SELECT * from user WHERE email = '".$_REQUEST['emailAddress']."'";


$stmt1 = mysql_query($tsql1);
if(!$stmt1)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{

	if(mysql_num_rows($stmt1)>0)
	{
			/* Redirect to original page */
  		$name = $_REQUEST['page'];
  		if($name=="register")
  		{
			header('Location:../login/'.$name.'.php?submitted=false');
  		}
  		else
  		{
    		header('Location:new-'.$name.'.php?submitted=false');
		}
	}	
	else
	{
		/* Query SQL Server for inserting data. */

    $name="";
    if(isset($_FILES['uploader']))
    {
        $name = $_FILES["uploader"]["name"];
        move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
    }

    /* Query SQL Server for inserting data. */
		$tsql = "INSERT INTO user (full_name, password, email, role_id, date_joined, user_image) VALUES ('".$_REQUEST['firstName']." ".$_REQUEST['lastName']."', '".$passwordToken."', '".$_REQUEST['emailAddress']."','".$_REQUEST['Role']."', '". date("Y-m-d H:i:s") ."', '". $name ."')";
		$stmt = mysql_query($tsql);
		if(!$stmt)
		{  
    		/* Error Message */
    		die("Query failed: ". mysql_error());
		}
		else
		{
  			/* Redirect to original page */
  			$name = $_REQUEST['page'];
  			if($name=="register")
  			{
  				header('Location:../login/'.$name.'.php?submitted=true');
  			}
  			else
  			{
    			header('Location:'.$name.'.php?submitted=true');
			}
	}
	}

}
}
?>