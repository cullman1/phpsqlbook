<?php
  include('database-connection.php');                // Step 1 Connect

  // Step 2 Query
  $sql = 'SELECT category_id, COUNT(*) AS total
            FROM article GROUP BY category_id';  // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $articles = $statement->fetchAll();               // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>GROUP BY and COUNT</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <p>
      <?php foreach ($articles as $row) { 
        echo $row->category_id . ': ' . $row->total . '<br>';
      }  ?>
    </p>
  </body>
</html>