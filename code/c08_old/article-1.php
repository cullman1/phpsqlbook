<?php
  require_once 'database-connection.php';          // Includes connection
  include 'classes/Article.php';                   // Includes class
  $article_id = ( isset($_GET['article_id']) ? $_GET['article_id'] : '');                   
  if (is_numeric($article_id)) {   // If got a numeric article id
    $sql = 'SELECT article.*, 
             CONCAT(user.forename, " ", user.surname) AS author,
             category.name AS category, 
             image.image_id AS image_id, image.file AS image_file, 
             image.alt AS image_alt 
            FROM article 
             LEFT JOIN user ON article.user_id = user.user_id
             LEFT JOIN category ON article.category_id = category.category_id
             LEFT JOIN articleimage ON articleimage.article_id = article.article_id
             LEFT JOIN image ON articleimage.image_id = image.image_id
            WHERE article.article_id=:id';                         // Query
    $statement = $pdo->prepare($sql);                      // Prepare
    $statement->bindValue(':id', $article_id, PDO::PARAM_INT); // Bind value from query
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
    <link rel="stylesheet" href="css/styles.css" />
  </head> 
  <body>
    <section>
      <h1><?= $article->title ?></h1>
       <img src="uploads<?= $article->image_file ?>" alt="<?= $article->image_alt ?>"/>
      <?= $article->content ?>
      <div class="credit">
        Posted by <i><?= $article->author ?></i> on <i><?= $article->created ?></i> 
        in <i><?= $article->category ?></i>.
      </div>
    </section>
  </body>
</html>