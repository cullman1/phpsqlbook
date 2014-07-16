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
$update_user_result = $dbHost->prepare($update_user_sql);
$update_user_result->execute();
if($update_user_result->errorCode()!=0) {  die("Update User Query failed"); }
else
{	
	/* Redirect to original page */
    header('Location:../admin/user.php');	
}
?>