<?php
  include('includes/config.php'); 

  $sql = 'SELECT article.title, article.published, 
          article.category_id, article.user_id, 
          category.id, category.name, 
          user.id, CONCAT(user.forename, + " ", + user.surname) AS fullname
          FROM article
          LEFT JOIN category ON article.category_id = category.id
          LEFT JOIN user ON article.user_id = user.id
          ORDER BY category.id ASC, article.published DESC, article.title ASC';

  $statement = $pdo->prepare($sql);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $articles = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Articles</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head> 
  <body>
    <?php include('includes/header.php'); ?>
    <table>
      <tr><th>Title</th><th>Category</th><th>Author</th><th>Published</th></tr>
      <?php foreach ($articles as $row) { ?>
      <tr>
        <td><?= $row->title ?></td>
        <td><?= $row->name ?></td>
        <td><?= $row->fullname ?></td>
        <td><?= $row->published ?></td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>