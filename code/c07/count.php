<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT COUNT(*) FROM user WHERE email LIKE "A%"'; // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare query
  $statement->execute();                         // Step 3 Execute query
  $result = $statement->fetchColumn();           // Step 3 Get the count
?>
<DOCTYPE html>
<html>
  <head>
    <title>COUNT()</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <p>
      <?= $result ?>
    </p>
  </body>
</html>