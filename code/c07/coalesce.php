<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT COALESCE(profile_image, forename, "friend") AS profile FROM user'; // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $users = $statement->fetchAll();               // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>COALESCE</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>

      <?php foreach ($users as $row) { ?>
        <p><?= $row->profile ?></p>
      <?php } ?>

  </body>
</html>