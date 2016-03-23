<?php
require_once('includes/database-connnection.php'); 
$article_id  = (filter_input(INPUT_GET, 'article_id',  FILTER_VALIDATE_INT) ? $_GET['article_id']  : 1); 

function get_article_by_id($id) {  
  $query = 'SELECT article.*, media.filepath, media.alt FROM article
  LEFT JOIN media ON article.media_id = media.id
  WHERE article.id = :id';
  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
  $statement->bindParam(":id", $id);                       // Bind
  $statement->execute();                                   // Execute
  $article = $statement->fetch(PDO::FETCH_OBJ);            // Matches in database
  return $article;                                         // Return as object
}

$article = get_article_by_id($article_id);
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?=$article->title;?></title>
  </head>
  <body>
  	<h1><?=$article->title;?></h1>
    <p><?=$article->content;?></p>
    <img src="<?=$article->filepath;?>" alt="<?=$article->alt;?>">
  </body>
</html>