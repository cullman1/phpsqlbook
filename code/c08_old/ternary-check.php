<?php
  require_once 'database-connection.php';
  $article_id = ( isset($_GET['id']) ? $_GET['id'] : '' );
  if (is_numeric($article_id)) {
    $sql = 'SELECT * 
            FROM article 
            WHERE article.article_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $article_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article  = $statement->fetch();
  }
?> 
<section>
  <?php if (is_numeric($article_id) && $article) { ?>
    <h1><?= $article->title ?></h1>
    <div class="row">
      <?= $article->content ?>
    </div>
  <?php } else { ?>
    <div class="row">No article was found</div>
  <?php } ?>
</section>