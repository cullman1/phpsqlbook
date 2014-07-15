<?php 
/* Db Details */
require_once('../includes/db_config.php');
$userimage = "";
/* Query nto update user */
if(isset($_FILES['uploader']))
{
    $userimage = $_FILES["uploader"]["name"];
    move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
}
else
{
    $userimage = $_REQUEST["UserImage"];
}

$update_user_sql = 'UPDATE user SET full_name= "' .$_REQUEST["UserName"].'", email="' .$_REQUEST["UserEmail"].'", user_image="' .$userimage.'" where user_id='.$_REQUEST["userid"];
echo $update_user_sql;
$update_user_result = $dbHost->query($update_user_sql);
if(!$update_user_result) {  die("Query failed: ". mysql_error()); }
else
{	
	/* Redirect to original page */
    header('Location:../admin/user.php');	
}
?>