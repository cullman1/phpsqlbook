<?php
define('ROOT', '/phpsqlbook/cms-final/'); 
require_once 'config.php';                            // Database connection
include 'classes/Category.php';                         // Category class
include 'classes/ArticleSummary.php';                   // ArticleSummary class

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {          // If got a category id

    // Get the category information
    $sql = 'SELECT * FROM category WHERE id=:id';                // Query
    $statement = $pdo->prepare($sql);                            // Prepare
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);           // Bind category id
    $statement->execute();                                       // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');      // Set fetch mode
    $category = $statement->fetch();                             // Store in variable

    // Get the articles in this category
    $sql = 'SELECT article.id, article.title, article.summary, 
            article.user_id, article.category_id, article.published,
            user.id as user_id, 
            CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, 
            category.name AS category,
            media.id as media_id, 
            media.file AS media_file, 
            media.alt AS media_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON articleimages.media_id = media.id
            WHERE article.category_id=:id 
            AND article.published = TRUE
            ORDER BY article.id DESC';                            // Query
    $statement = $pdo->prepare($sql);                             // Prepare
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);            // Bind category id
    $statement->execute();                                        // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS, 'ArticleSummary'); // Set fetch mode
    $article_list = $statement->fetchAll();                       // Store in variable
}

if (empty($category) || empty($article_list)) {                 // If objects empty
    header( "Location: page-not-found.php" );
   exit();              // Redirect user
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?= $category->name ?></title>
    <meta name="description" value="<?= $category->description ?>">
    <link rel="stylesheet" href="<?= ROOT ?>css/styles.css" />
  </head>
  <body>
    <h1><?= $category->name ?></h1>
    <?php foreach ($article_list as $article) { ?>
      <div class="article">
        <img src="<?= ROOT ?>uploads/<?= $article->media_file ?>" alt="<?= $article->media_alt ?>">
        <a href="article.php?id=<?=$article->id?>">
          <?=$article->title?><?=$article->summary?></a>
      </div>
    <?php } ?>
  </body>
</html>