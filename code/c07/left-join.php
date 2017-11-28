<?php
  include('database-connection.php');                // Step 1 Connect

  $sql = 'SELECT user.forename, user.surname, article.title
    FROM user
    LEFT JOIN article
    ON user.id = article.user_id
    WHERE (user.id = 1) OR (user.id = 5)';       // Step 2 Query

  $statement = $pdo->prepare($sql);              // Step 2 Prepare
  $statement->execute();                         // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 3 Set fetch mode to array
  $users = $statement->fetchAll();               // Step 3 Get all rows ready to display
?>

<DOCTYPE html>
<html>
  <head>
    <title>LEFT JOIN</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <p>
    <?php foreach ($users as $row) { 
      echo $row->forename . ' ' . $row->surname;
      echo ' - ' . $row->title . '<br>';
    } ?>
    </p>
  </body>
</html>