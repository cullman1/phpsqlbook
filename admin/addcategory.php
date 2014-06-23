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
  
/* Query SQL Server for inserting data. */
$tsql = "INSERT INTO category (category_name, category_template) VALUES ('".$_REQUEST['CategoryName']."', '".$_REQUEST['CategoryParent']."')";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{
  	/* Redirect to original page */
    header('Location:../admin/new-category.php?submitted=true');
}
?>