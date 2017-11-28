<?php
  include('database-connection.php');                 // Step 1 Connection
  include('classes/User.php');                        // Include user class

  $sql = 'SELECT id, email, forename, surname, joined, profile_image FROM user';//Step 2
  $statement = $pdo->prepare($sql);                   // Step 2 Check query
  $statement->execute();                              // Step 3 Execute
  $statement->setFetchMode(PDO::FETCH_CLASS, 'User'); // Step 3 Set fetch mode
  $users = $statement->fetchAll();                    // Step 3 Create recordset
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Users</title>
  <link rel="stylesheet" href="css/styles.css" />
 </head> 
 <body>
  <h1>Users</h1> 
   <?php foreach ($users as $user) { ?>
    <section class="card user">
     <img src="img/<?= $user->profile_image ?>" alt="<?= $user->getFullName() ?>"/> 
     <h1><?= $user->getFullName() ?></h1>
     <p>Joined: <?= $user->joined ?></p>
    </section>
   <?php } ?>
  </body>
</html>