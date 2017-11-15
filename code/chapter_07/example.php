<?php
 define('ROOT', '/phpsqlbook/cms-final/'); 
include('config.php'); 
include('classes/Article.php'); 

$sql = 'SELECT article.*, 
            user.id AS user_id, 
            CONCAT(user.forename, " ", user.surname) AS author, 
            user.profile_image AS author_image, 
            category.id AS category_id, 
            category.name AS category,
                  media.id AS media_id, 
            media.file as media_file, 
            media.alt AS media_alt 
          FROM article 
            LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON articleimages.media_id = media.id
            WHERE article.id=161';
$statement = $pdo->prepare($sql);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_CLASS, 'Article');
$article  = $statement->fetch();
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
      <img src="<?= ROOT ?>uploads/<?= $article->media_filename ?>" alt="<?= $article->media_alt ?>" />
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
