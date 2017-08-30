<?php
  include('includes/config.php');                 // Step 1 Connection

  $sql = 'SELECT * FROM user WHERE id = 1';       // Step 2 SQL statement
  $statement = $pdo->prepare($sql);               // Step 2 Prepare query

  $statement->execute();                          // Step 3 Execute query 
  $user = $statement->fetch(PDO::FETCH_ASSOC);    // Step 3 Set fetch method
?>

<DOCTYPE html>                                    <!-- Step 4 Display results -->
<html>
  <head>
    <title>User: <?= $user['forename'] ?> <?= $user['surname'] ?></title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <section class="card user">
      <img src="img/<?= $user['image']?>" alt="<?= $user['forename'] ?>" /> 
      <h1><?= $user['forename'] ?> <?= $user['surname'] ?></h1>
      <p><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></p>
      <p>Joined: <?= $user['joined'] ?></p>
    </section>
  <body>
</html>