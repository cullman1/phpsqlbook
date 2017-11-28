<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT forename AS first_name, surname AS last_name FROM user'; // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $users = $statement->fetchAll();               // Step 3 Get all rows ready to display
?>
<DOCTYPE html>
<html>
  <head>
    <title>Aliases</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>

      <?php foreach ($users as $row) { 
        echo '<p>' . $row->first_name . ' ';
        echo $row->last_name . '</p>';
      }  ?>

  </body>
</html>