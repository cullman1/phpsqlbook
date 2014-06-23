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
if(isset($_FILES['uploader']))
{
    $folder = "../uploads/".$_FILES["uploader"]["name"];
    $thumbnail = "";
    if(isset($_FILES["uploader"]["thumbnail"]))
    {
        $thumbnail = "../uploads/".$_FILES["uploader"]["thumbnail"];
    }

    move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
              
    /* Query SQL Server for inserting data. */
    $tsql2 = "INSERT INTO media (thumbnail, media_title, name, file_type, url, size, date_uploaded) VALUES ('". $thumbnail."','".$_REQUEST['title']."','".$_FILES['uploader']['name']."', '".$_FILES['uploader']['type']."', '".$folder."', '".$_FILES['uploader']['size']."', '". date("Y-m-d H:i:s") ."')";
    $stmt2 = mysql_query($tsql2);
    if(!$stmt2)
    {  
        /* Error Message */
    	die("Query failed: ". mysql_error());
    }
             
}
else if ((!$_FILES) && isset($_REQUEST["submitted"]))
{
    echo "<br/><br/><span class='red'>File upload failed</span>";
} 
?>