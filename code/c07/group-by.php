<?php
  include('database-connection.php');                // Step 1 Connect

  // Step 2 Query
  $sql = 'SELECT title, category_id FROM article
            ORDER BY category_id ASC, title ASC';

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $articles = $statement->fetchAll();            // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>GROUP BY</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <p>
      <?php foreach ($articles as $row) { 
        echo $row->category_id . ': ' . $row->title . '<br>';
      } ?>
    </p>
  </body>
</html>