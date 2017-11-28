<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT SUM(id) FROM user ';            // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare query
  $statement->execute();                         // Step 3 Execute query
  $result = $statement->fetchColumn();           // Step 3 Get the sum
?>
<DOCTYPE html>
<html>
  <head>
    <title>SUM()</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>

      <?= $result ?>

  </body>
</html>