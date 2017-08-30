<?php require_once('../includes/db_config.php');
if (isset($_GET["publish"])) {
$del_article_set = $dbHost->prepare("update article set date_published = null where article_id= :article_id");
} else {
$del_article_set = $dbHost->prepare("update article set date_published = '". date('Y-m-d H:i:s')."' where article_id= :article_id");
}
$del_article_set->bindParam(":article_id",$_GET["article_id"]);
$del_article_set->execute();
if($del_article_set->errorCode()!=0) {  
   die("Delete Article Query failed"); 
} else {
    header('Location:../chapter_06/hide-data.php');
} ?>
