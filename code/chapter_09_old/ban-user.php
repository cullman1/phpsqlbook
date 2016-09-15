<?php
require_once('authenticate.php'); 
require_once('../includes/db_config.php');

if (isset($_REQUEST["publish"])) {
    $query = "update user set active = active ^ 1 WHERE user_id= :id";
        $statement = $dbHost->prepare($query);
    $statement->bindParam(":id",$_REQUEST["userid"]);

    $statement->execute();
    if($statement->errorCode()!=0) {  die("Update User Query failed"); }
    else {
        $query = "select * from role where role = :role";
        $statement = $dbHost->prepare($query);
        $statement->bindParam(":id",$_REQUEST["publish"]);
        $statement->execute();
        while($row = $statement->fetch()) 
        { 
            $name = $row["role_name"];
            header('Location:../admin/'.$name.'.php?submitted=missing');
        }
    }
} ?>