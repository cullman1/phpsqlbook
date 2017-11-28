<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT article.title, article.published, category.name
          FROM article INNER JOIN category
          ON article.category_id = category.id
          ORDER BY category.id, article.published'; // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $articles = $statement->fetchAll();            // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>INNER JOIN</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <p>
    <?php foreach ($articles as $row) { 
      echo $row->name . ' - ' . $row->title .  '<br>';
    } ?>
    </p>
  </body>
</html>