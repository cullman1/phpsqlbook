<?php
include_once('../includes/db_config.php');
$sel_users_set = $dbHost->prepare("Select * from Users 
WHERE email_address= :email");
$sel_users_set->bindParam(":email", $_GET["email"]);
$sel_users_set->execute();
$rs=array();
while($sel_users_row = $sel_users_set ->fetch()) {
	$rs[] = $sel_users_row;
}
echo json_encode($rs); 

?>

