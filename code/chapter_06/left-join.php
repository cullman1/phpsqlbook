<?php
include('includes/config.php'); // Connect

$sql = 'SELECT user.forename, user.surname, 
article.title
FROM user left JOIN article
ON article.user_id  = user.id';      // Query

$statement = $pdo->prepare($sql);           // Prepare
$statement->execute();                      // Execute
$statement->setFetchMode(PDO::FETCH_OBJ);   // Object
$users = $statement->fetchAll();            // Fetch

foreach ($users as $row) {                  // Display
  echo $row->forename . ' ' . $row->surname;
  echo ' - ' . $row->title .  '<br>';
}
?>