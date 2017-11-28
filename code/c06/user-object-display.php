<?php
  include('database-connection.php');                     // Step 1 Connection
  $sql = 'SELECT forename, surname, joined, profile_image FROM user WHERE id = 1'; //Step 2    
  $statement = $pdo->prepare($sql);                   // Step 2 Check query
  $statement->execute();                              // Step 3 Execute query
  $statement->setFetchMode(PDO::FETCH_OBJ);           // Step 3 Fetch mode
  $user = $statement->fetch();                        // Step 3 Store data in object
  var_dump($user);                                    // Step 4 Display object
?>