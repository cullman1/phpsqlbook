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
session_start();
/* Query SQL Server for inserting data. */
$tsql = "INSERT INTO article (title, content, date_posted, category_id, parent_id, user_id) VALUES ('".$_REQUEST['ArticleTitle']."', '".$_REQUEST['ArticleContent']."',  '". date("Y-m-d H:i:s") ."', '".$_REQUEST['CategoryId']."', '".$_REQUEST['PageId']."', '".$_SESSION['authenticated']."')";
$stmt = mysql_query($tsql);
$newarticleid = mysql_insert_id();
if(!$stmt)
{  
    /* Error Message */
    die("Query failed1: ". mysql_error());
}
else
{
	$articleid = "0";
	if(isset($_REQUEST['article_id']))
	{
		$articleid = $_REQUEST['article_id'];
	}
	else
	{
		$articleid = mysql_insert_id($conn);
	}

	
	if(isset($_FILES['document_upload']))
	{
		if($_FILES["document_upload"]["name"]!="")
		{
		 $folder = "../uploads/".$_FILES["document_upload"]["name"];
		move_uploaded_file($_FILES['document_upload']['tmp_name'], $folder);
              
    	/* Query SQL Server for inserting data. */
    	$tsql3 = "INSERT INTO media (media_title, name, file_type, url, size, date_uploaded) VALUES ('".$_FILES["document_upload"]["name"]."','".$_FILES['document_upload']['name']."', '".$_FILES['document_upload']['type']."', '".$folder."', '".$_FILES['document_upload']['size']."', '". date("Y-m-d H:i:s") ."')";
    	$stmt3 = mysql_query($tsql3);
    	if(!$stmt3)
    	{  
        	/* Error Message */
      		die("Query failed: ". mysql_error());
    	}
    	$newmediaid = mysql_insert_id();

    	/* Query SQL Server for inserting data. */
    	$tsql4 = "INSERT INTO media_link (article_id, media_id) VALUES (".$newarticleid.", '".$newmediaid."')";
    	$stmt4 = mysql_query($tsql4);
    	if(!$stmt4)
    	{  
        	/* Error Message */
      		die("Query failed: ". mysql_error());
    	}
    	}
	}


	if(isset($_REQUEST['fimagehidden']))
	{
		$tsql2 = "UPDATE media set article_id =".$articleid." where media_id=".$_REQUEST['fimagehidden'];
		$stmt2 = mysql_query($tsql2);
		if(!$stmt2)
		{ 
    	    /* Error Message */
    		die("Query failed2: ". mysql_error());
		}
		else
		{
			/* Redirect to original page */
			header('Location:../admin/AddArticle.php?submitted=true');
		}
	}
	else
	{
		/* Redirect to original page */
		header('Location:../admin/AddArticle.php?submitted=true');
	}
}
?>