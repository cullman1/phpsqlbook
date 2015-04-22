<?php require_once('../includes/db_config.php');
$del_article_set = $dbHost->prepare("delete FROM article where article_id= :article_id");
$del_article_sql = $dbHost->bindParam(":article_id",$_POST["article_id"]);
$del_article_set->execute();
if($del_article_result->errorCode()!=0) {  
   die("Delete Article Query failed"); 
}
else {
    header('Location:../chapter_06/hide-data.php?deleted=true');
} ?>
