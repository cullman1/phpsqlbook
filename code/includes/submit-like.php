<?php
require_once('../classes/registry.php');
$registry = Registry::instance();
$pdo =  $registry->get('pdo');

if($_REQUEST['user_id']=="0") {
    header('Location:../login/login-user.php');
    echo "should have gone there";
}
else {    
    if($_REQUEST['liked']=="Like") {
        $insert_like_sql = "INSERT INTO article_like (user_id, article_id) VALUES (".$_REQUEST['user_id'].",".$_REQUEST['article_id'].")";
    } else {
        $insert_like_sql = "DELETE * FROM article_like WHERE user_id= (".$_REQUEST['user_id']." and article_id=".$_REQUEST['article_id'].")";
    }
    $insert_like_result = $pdo->prepare($insert_like_sql);
    $insert_like_result->execute();
    if($insert_like_result->errorCode()!=0) {  die("Insert Media Query failed"); }
}
?>