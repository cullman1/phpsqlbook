<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query */

$tsql = "UPDATE 387732_phpbook1.article SET title= '" .$_REQUEST["ArticleTitle"]."', content='" .$_REQUEST["ArticleContent"]. "', category_id=" .$_REQUEST["CategoryId"]. ", parent_id=" .$_REQUEST["PageId"]. " where article_id=".$_REQUEST["article_id"];
echo $tsql;
$stmt = mysql_query($tsql);

if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{

	if(isset($_FILES['document_upload']))
	{
		if($_FILES["document_upload"]["name"]!="")
		{
		 $folder = "../uploads/".$_FILES["document_upload"]["name"];
		move_uploaded_file($_FILES['document_upload']['tmp_name'], $folder);
              
    	/* Query SQL Server for inserting data. */
    	$tsql5 = "INSERT INTO media (media_title, name, file_type, url, size, date_uploaded) VALUES ('".$_FILES["document_upload"]["name"]."','".$_FILES['document_upload']['name']."', '".$_FILES['document_upload']['type']."', '".$folder."', '".$_FILES['document_upload']['size']."', '". date("Y-m-d H:i:s") ."')";
    	$stmt5 = mysql_query($tsql5);
    	if(!$stmt5)
    	{  
        	/* Error Message */
      		die("Query failed: ". mysql_error());
    	}



		$tsql3 = "INSERT media_link (article_id, media_id) VALUES  (".$_REQUEST["article_id"].",".mysql_insert_id().")";
		$stmt3 = mysql_query($tsql3);
		if(!$stmt3)
		{ 
    	    /* Error Message */
    		die("Query failed2: ". mysql_error()."<br/>".$tsql2);
		}
		}
	}


	if($_REQUEST['fimagehidden']!="")
	{
		$tsql2 = "UPDATE 387732_phpbook1.media SET article_id =".$_REQUEST["article_id"]." where media_id=".$_REQUEST['fimagehidden'];
		$stmt2 = mysql_query($tsql2);
		if(!$stmt2)
		{ 
    	    /* Error Message */
    		die("Query failed2: ". mysql_error()."<br/>".$tsql2);
		}
		else
		{
			/* Redirect to original page */
    		header('Location:../admin/EditArticle2.php?submitted=true&article_id='.$_REQUEST["article_id"]);
		}
	}
	else
	{
		/* Redirect to original page */
		header('Location:../admin/EditArticle2.php?submitted=true&article_id='.$_REQUEST["article_id"]);
	}
	
}
?>