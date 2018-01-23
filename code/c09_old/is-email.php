<?php
require_once('includes/config.php');                        // Connect
 

 $id1 = filter_input(INPUT_GET, 'id1', FILTER_VALIDATE_INT);
 $article1 =  $articleManager->getArticleById($id1);
 echo $article1->title;

 $id2 = $_GET["id2"];
 if ((filter_var($id2, FILTER_VALIDATE_INT))) {
       $article2 =  $articleManager->getArticleById($id1);
       echo $article2->title;
 }

?>
<!DOCTYPE html>
<html>
  <head><title></title></head>
  <body>