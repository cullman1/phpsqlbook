<?php
  include('database-connection.php'); 
  include('classes/Article.php'); 
  $sql = 'SELECT article.*, 
            user.id AS user_id, 
            CONCAT(user.forename, " ", user.surname) AS author, 
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
            WHERE article.id = 1';
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
    <link rel="stylesheet" href="css/styles.css" />
  </head> 
  <body>
    <section>
      <h1><?= $article->title ?></h1>
      <img src="uploads/<?= $article->media_file ?>" alt="<?= $article->media_alt ?>" />
      <?= $article->content ?>
      <div class="credit">
        Posted by <i><?= $article->author ?></i>
        on <i><?= $article->created ?></i> 
        in <i><?= $article->category ?></i>.
      </div>
    </section>
  </body>
</html>