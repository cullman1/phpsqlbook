<?php
include_once('../includes/db_config.php');

$select_users_sql = "Select * from Users WHERE full_name Like '".$_REQUEST['checkfirst']."%";

$select_users_result = $dbHost->prepare($select_users_sql);
$select_users_result->execute();
$select_users_result->setFetchMode(PDO::FETCH_ASSOC);	

$rs=array();
while($select_users_row = $select_users_result ->fetch()) {
    
	$rs[] = $select_users_row;
}
echo json_encode($rs);

?>

