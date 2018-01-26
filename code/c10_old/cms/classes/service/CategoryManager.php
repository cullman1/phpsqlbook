<?php
class CategoryManager {

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function getCategoryById($id) {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category = $statement->fetch();
    if (!$category) {
      return null;
    }
    return $category;
  }  

  public function getNavigationCategories(){
    $pdo = $this->pdo;
    $sql = 'SELECT DISTINCT category.*
            FROM category 
            INNER JOIN article ON article.category_id = category.id
            WHERE navigation = TRUE';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category_list = $statement->fetchAll();
    if (!$category_list) {
      return null;
    }
    return $category_list;
  }

  public function create($category) {
    $pdo = $this->pdo;                                              // Connection
    $sql = 'INSERT INTO category (name, description, navigation) 
            VALUES (:name, :description, :navigation)';             // SQL
    $statement = $pdo->prepare($sql);                               // Prepare
    $statement->bindValue(':name', $category->name);                // Bind name
    $statement->bindValue(':description', $category->description);  // Bind description
    $statement->bindValue(':navigation', $category->navigation, PDO::PARAM_BOOL);         
  try {                                                              // Try block
    $statement->execute();                                           // Execute
     $category->id = $connection->lastInsertId();          // Add new id to object
    return TRUE;                                                  // Succeeded
  } catch (PDOException $error) {                                    // Otherwise
    if ($error->errorInfo[1] == 1062) {                              // If a duplicate
      return 'A category with that name exists - try a different name'; // Error
    } else {                                                         // Otherwise
      return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
    }                                                                // End if/else
  }                                                                  // End catch block
}
  public function update($category){
    $pdo = $this->pdo;                                              // Connection
    $sql = 'UPDATE category SET name = :name, description = :description, 
            navigation = :navigation WHERE id = :id';               // SQL
    $statement = $pdo->prepare($sql);                               // Prepare       
    $statement->bindValue(':id', $category->id, PDO::PARAM_INT);    // Bind id
    $statement->bindValue(':name', $category->name);                // Bind name
    $statement->bindValue(':description', $category->description);  // Bind description
    $statement->bindValue(':navigation', $category->navigation);    // Bind navigation      
    try {                                                           // Try to execute
      $statement->execute();                                        // Execute SQL
    } catch (PDOException $error) {                                 // Otherwise
      return $error->errorInfo[1] . ': ' . $error->errorInfo[2];    // Error   
    }
    return TRUE;                                                    // Say succeeded
  }
  public function delete($id){
    $pdo = $this->pdo;                                              // Connection
    $sql = 'DELETE FROM category WHERE id = :id';                   // SQL
    $statement = $pdo->prepare($sql);                               // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);              // Bind ID
    try {                                                           // Try to execute
      $statement->execute();                                        // Execute SQL
    } catch (PDOException $error) {                                 // Otherwise
      return $error->errorInfo[1] . ': ' . $error->errorInfo[2];    // Error
    }
    return TRUE;                                                    // Say succeeeded
  }

  public function getAllCategories() {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category_list = $statement->fetchAll();
    if (!$category_list) {
      return null;
    }
    return $category_list;
  }

}