<?php
define('ROOT', '/phpsqlbook/cms-final/'); 
require_once 'database-connection.php';          // Includes connection
  include 'classes/Article.php';                   // Includes class
  $id = ( isset($_GET['id']) ? $_GET['id'] : '');                     // Includes connection and class

if ( is_numeric($id) ) {   // If got a numeric article id
    $sql = 'SELECT article.*, user.id AS user_id, 
          CONCAT(user.forename, " ", user.surname) AS author, user.profile_image AS  
          author_image, category.id AS category_id, category.name AS category, media.id  
          AS media_id, media.file AS media_file, media.alt AS media_alt 
          FROM article 
          LEFT JOIN user ON article.user_id = user.id
          LEFT JOIN category ON article.category_id = category.id
          LEFT JOIN articleimages ON articleimages.article_id = article.id
          LEFT JOIN media ON articleimages.media_id = media.id
          WHERE article.id=:id';                         // Query
    $statement = $pdo->prepare($sql);                      // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);     // Bind value from query string
    $statement->execute();                                 // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Article'); // Set fetch mode
    $article = $statement->fetch();                        // Store data in $article  
}
    if (empty($article)) {                                 // If no article
        header( "Location: page-not-found.php" );
        exit();              // Redirect user
    }

?>


<!DOCTYPE html>
<html>
  <head>
    <title><?= $article->title ?></title>
    <meta name="description" value="<?= $article->title ?>" />
    <link rel="stylesheet" href="<?= ROOT ?>css/styles.css" />
  </head> 
  <body>
    <section>
      <h1><?= $article->title ?></h1>
      <img src="<?= ROOT ?>uploads/<?= $article->media_file ?>" alt="<?= $article->media_alt ?>" />
      <?= $article->content ?>
      <div class="credit">
        <img src="<?= ROOT ?>uploads/<?= $article->author_image ?>" 
             alt="<?= $article->author ?>">
        Posted by <i><?= $article->author ?></i>
        on <i><?= $article->created ?></i> 
        in <i><?= $article->category ?></i>.
      </div>
    </section>
  </body>
</html>

