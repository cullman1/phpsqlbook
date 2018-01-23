<?php
  require_once 'database-connection.php';
  
  $article_id = 99999999;
  $sql = 'SELECT * FROM article WHERE article_id= :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $article_id, 
                        PDO::PARAM_INT);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ); 
  $article = $statement->fetch(); 
  if (empty($article)) {
    header( "Location: page-not-found.php" );
    exit();
  }
?> 
<section class="jumbotron text-center">
  <h1><?= $article->title ?></h1>
    <div class="row">
      <?= $article->content ?>
    </div>
</section>