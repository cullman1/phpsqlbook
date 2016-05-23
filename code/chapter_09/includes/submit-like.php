<?php

require_once('../classes/registry.php');
require_once('../classes/configuration.php');

$registry = Registry::instance();
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

if ($_REQUEST['user_id']=="0") {
    header('Location:../login/login-user.php');
}
else {    
        if($_REQUEST['liked']=="0") {
            $insert_like_sql = "INSERT INTO article_like (user_id, article_id) VALUES (".$_REQUEST['user_id'].",".$_REQUEST['article_id'].")";
        } 
        else {
            $insert_like_sql = "DELETE FROM article_like WHERE user_id= ".$_REQUEST['user_id']." and article_id=".$_REQUEST['article_id'];
        }
        $insert_like_result = $pdo->prepare($insert_like_sql);
        $insert_like_result->execute();
        if ($insert_like_result->errorCode()!=0) { 
            die("Insert Media Query failed"); 
        }
        $return = $_SERVER["HTTP_REFERER"];
        header('Location:'.$return);
}
?>