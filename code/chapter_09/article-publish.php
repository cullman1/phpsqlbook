<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 

	function unpublish_article($id) {
              $query = "update article set published = NULL WHERE id= :id";
              $statement = $GLOBALS['connection']->prepare($query);
              $statement->bindParam(":id", $id);  
              $statement->execute();
            }

            function publish_article($id){
              $date = date("Y-m-d H:i:s");
              $query = "update article set published = :date WHERE id= :id";
              $statement = $GLOBALS['connection']->prepare($query);
              $statement->bindParam(":id", $id);
              $statement->bindParam(":date", $date);
              $statement->execute();
       
            }

       $publish = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
       $id = filter_input(INPUT_GET, "article_id", FILTER_DEFAULT);
       if ($publish == "publish") {
             publish_article($id); 
header('Location: article-list-role.php');
       } else if ($publish == "unpublish") {
        unpublish_article($id);
       header('Location: article-list-role.php');
       } ?>