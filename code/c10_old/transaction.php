<?php
  require_once('config.php');                                // Database connection
  try {                                                      // Transaction in try block
    $pdo = $cms->getPDO();
    $pdo->beginTransaction();                                // Start transaction
    // Add category
    $query='INSERT INTO category(name, description, navigation) 
            VALUES ("News", "The latest news from Creative Folk.", 1)';
    $statement = $pdo->prepare($query);
    $statement->execute();  
    echo "Category can be added<br>";
    $id = $pdo->lastInsertId();  
  
   // Add article
   $query='INSERT INTO article (title, content, summary, category_id, user_id)
           VALUES("Looking to hire", "Creative Folk are looking to hire new designers
                   Please contact ivy@example.org for details.", 
                   "Creative Folk looking for designers",' . $id .', 1)';
    $statement = $pdo->prepare($query);      
    $statement->execute();
    echo "Article can be added<br>";

    $pdo->commit();                                           // Commit transaction
    echo 'Update completed <a href="cms/admin/categories.php">See categories</a>';
  } catch (PDOException $error) {                             // Failed to update
    echo 'We were not able to create category and article. ' . $error->getMessage();       
    $pdo->rollback();                                  // Roll back all SQL
  }
?>