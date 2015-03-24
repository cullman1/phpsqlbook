<?php
include_once('../includes/db_config.php');
$search = $_GET["term"];
$select_users_sql = "Select full_name from Users";

$select_users_result = $dbHost->prepare($select_users_sql);
$select_users_result->execute();
$select_users_result->setFetchMode(PDO::FETCH_ASSOC);	

$rs=array();
while($select_users_row = $select_users_result ->fetch()) {
    
	$rs[] = $select_users_row["full_name"];
}


function find($item) {
    global $search;
    return stripos($item, $search) !== false;
}

print(json_encode(array_values(array_filter($rs, "find"))));

?>


