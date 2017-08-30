<?php
  require_once('includes/config.php');        // Connect

  $id = (isset($_GET['id']) ? $_GET['id'] : '');     // category id

  // Get the name of the category and store in $category
  $sql = 'SELECT name FROM category WHERE id=:id'; // Query
  $statement = $pdo->prepare($sql);         // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT); // Bind value from query string
  $statement->execute();                             // Execute
  $category = $statement->fetch(PDO::FETCH_OBJ);     // Fetch

 // Get the list of articles in the category and store in $article_list
  $sql = 'SELECT article.id, article.title, article.media_id, 
      media.id, media.filepath, media.thumb, media.alt, media.mediatype
      FROM article
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.category_id=:id';                 // Query
  $statement = $pdo->prepare($sql);                   // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
  $statement->execute();                              // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);           // Object
  $article_list = $statement->fetch();             // Fetch
  var_dump($article_list);
  if (empty($category) || empty($article_list)) {
      // header( "Location: 404.php" );
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $category->name ?></title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>

    <h1><?= $category->name ?></h1>

    <?php foreach ($article_list as $article) { ?>
      <div class="article">
        <img src="<?= $article->filepath ?><?= $article->thumb ?>" 
             alt="<?= $article->alt ?>" type="<?= $article->mediatype ?>">
        <a href="article-1.php?id=<?=$article->id?>"><?=$article->title?></a>
      </div>
    <?php } ?>

  </body>
</html>