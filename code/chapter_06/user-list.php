<?php
  include('includes/config.php');                     // Step 1 Connection
  include('includes/user.php');                  // Include User class
  $sql = 'SELECT * FROM user';                        // Step 2 SQL Statement
  $statement = $pdo->prepare($sql);                   // Step 2 Check query
  $statement->execute();                              // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); 
                                                      // Step 3 Set fetch mode
  $users = $statement->fetchAll();                    // Step 3 Create recordset
?>
<DOCTYPE html>
<html>
  <head>
    <title>Users</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <?php foreach ($users as $user) { ?>
      <section class="card user">
        <img src="img/<?= $user->image ?>" alt="<?= $user->image ?>" /> 
        <h1><?= $user->getFullName() ?></h1>
        <p><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></p>
        <p>Joined: <?= $user->joined ?></p>
      </section>
    <?php }  ?>
  </body>
</html>