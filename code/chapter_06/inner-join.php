<?php
include('includes/config.php');// Connect

$sql = 'SELECT article.title, article.published, category.name
FROM article INNER JOIN category
ON article.category_id = category.id
ORDER BY category.id, article.published';   // Query

$statement = $pdo->prepare($sql);           // Prepare
$statement->execute();                      // Execute
$statement->setFetchMode(PDO::FETCH_OBJ);   // Object
$articles = $statement->fetchAll();         // Fetch

foreach ($articles as $row) {               // Display
  echo $row->name . ' - ' . $row->title .  '<br>';
}