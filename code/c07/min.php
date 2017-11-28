<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT email FROM user WHERE email = (SELECT MIN(email) FROM user)'; // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare query
  $statement->execute();                         // Step 3 Execute query
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $users = $statement->fetchAll();               // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>MIN()</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>

      <?php foreach ($users as $row) { ?>
        <p><?= $row->email ?></p>
      <?php }  ?>

  </body>
</html>