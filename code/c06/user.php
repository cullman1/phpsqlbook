<?php
  include('database-connection.php');                 // Step 1 Connection

  $sql = 'SELECT forename, surname, joined, profile_image FROM user WHERE id = 1'; // Step 2 SQL
  $statement = $pdo->prepare($sql);               // Step 2 Prepare query

  $statement->execute();                          // Step 3 Execute query 
  $statement->setFetchMode(PDO::FETCH_ASSOC);     // Step 3 Fetch mode
  $user = $statement->fetch();                    // Step 3 Collect the data
?>

<DOCTYPE html>                                    <!-- Step 4 Display results -->
<html>
  <head>
    <title>User: <?= $user['forename'] ?> <?= $user['surname'] ?></title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <section class="card user">
      <img src="img/<?= $user['profile_image']?>" alt="<?= $user['forename'] ?>" /> 
      <h1><?= $user['forename'] ?> <?= $user['surname'] ?></h1>
      <p>Joined: <?= $user['joined'] ?></p>
    </section>
  <body>
</html>