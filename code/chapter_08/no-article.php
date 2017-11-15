<?php
  require_once 'database-connection.php';
  $id = 99999999;
  $sql = 'SELECT * FROM article WHERE id= :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id , PDO::PARAM_INT);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ); 
  $article = $statement->fetch(); 
  if (empty($article)) {
    header( "Location: page-not-found.php" );
    exit();
  }
  include 'includes/header.php';
?>
<section class="jumbotron text-center">
<div><?= $article->title; ?></div>
</section>
<?php include 'includes/footer.php'; ?>