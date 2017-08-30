<?php
  include('includes/config.php');                     // Step 1 Connection
  include('includes/user.php');                  // Include the User class
  $sql = 'SELECT * FROM user WHERE id = 1';           // Step 2 SQL statement
  $statement = $pdo->prepare($sql);                  // Step 2 Check query
  $statement->execute();                              // Step 3 Execute query
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); 
                                                      // Step 3 Set fetch mode
  $user = $statement->fetch();                        // Step 3 store data in object
?>
<DOCTYPE html>
<html>
  <head>
    <title>User: <?= $user->getFullName() ?></title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <section class="card user">
      <img src="img/<?= $user->image ?>" alt="<?= $user->image ?>" />
      <h1><?= $user->getFullName() ?></h1>
      <p><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></p>
      <p>Joined: <?= $user->joined ?></p>
    </section>
  <body>
</html>