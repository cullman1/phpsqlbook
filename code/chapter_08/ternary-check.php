<?php
require_once 'database-connection.php';
  $id  = ( isset($_GET['id']) ? $_GET['id'] : '' );
  if (is_numeric($id)) {
    $sql = 'SELECT article.* 
            FROM article 
            WHERE article.id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id , PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article  = $statement->fetch();
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Check</title>
    <meta name="description" value="Example" />
    <link rel="stylesheet" href="../../cms-final/css/styles.css" />
  </head> 
  <body>
<section>
  <?php if (is_numeric($id) && $article) { ?>
    <h1><?= $article->title ?></h1>
    <div class="row">
      <?= $article->content ?>
    </div>
    <?php } else { ?>
      <div class="row">No article was found</div>
    <?php } ?>
</section>
</body>
</html>