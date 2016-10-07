<?php
include_once('../includes/db_config.php');
$search = $_GET["term"];

function get_users_list($dbHost) {
    $query = "Select full_name from Users";
    $statement = $dbHost->prepare($query);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);	
    $rs=array();
    while($row = $statement ->fetch()) {
        $rs[] = $row["full_name"];
    }
    return $rs;
}

function find($item) {
    global $search;
    return stripos($item, $search) !== false;
}

$rs = get_users_list($dbHost);
print(json_encode(array_values(array_filter($rs, "find"))));

?>


