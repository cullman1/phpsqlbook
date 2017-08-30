<?php require_once('../includes/db_config.php');
$update_user_result = $dbHost->prepare("UPDATE Users SET full_name= :name, email_address= :email where user_id= :user_id");
$ins_user_set->bindParam(":name", $_POST["name"]);  
$ins_user_set->bindParam(":email", $_POST["email"]);  
$ins_user_set->bindParam(":user_id", $_POST["userid"]);  
$update_user_result->execute();
if($update_user_result->errorCode()!=0) {  
    echo ("Update query failed");
} else {	
    header('Location:../chapter_06/updateform.php?submitted=true');	
} ?>