<?php

class CategoryManager
{

  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getNavigationCategories(){
    $pdo = $this->pdo;
    $sql = 'SELECT DISTINCT category.*
            FROM category 
            INNER JOIN article ON article.category_id = category.id
            WHERE navigation = TRUE ';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category_list = $statement->fetchAll();
    if (!$category_list) {
      return null;
    }
    return $category_list;
  }

  public function getCategoryById($id)
  {
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

  public function getAllCategories() {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category = $statement->fetchAll();
    if (!$category) {
      return null;
    }
    return $category;
  }

  public function create($category) {
    $pdo = $this->pdo;
    $sql = 'INSERT INTO category (name, description, navigation, seo_name) VALUES (:name, :description, :navigation, :seo_name)'; // SQL
    $statement = $pdo->prepare($sql);                                      // Prepare
    $statement->bindValue(':name', $category->name);                       // Bind name
    $statement->bindValue(':description', $category->description);         // Bind description
    $statement->bindValue(':navigation', $category->navigation, PDO::PARAM_BOOL);  // Bind navigation
    $statement->bindValue(':seo_name',   Utilities::createSlug($category->name));
    try {
      $statement->execute();                                               // Execute SQL
      $category->id = $pdo->lastInsertId();                                // Add id to object
      $result   = TRUE;                                                    // Get id created
    } catch (PDOException $error) {                                        // Otherwise
      if ($error->errorInfo[1] == 1062) {                                  // If it is a duplicate
        $result = 'A category with that name exists - try a different name';
      } else {
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
      }
    }
    return $result;                                                   // Say succeeded
  }

  public function update($category){
    $pdo = $this->pdo;
    $sql = 'UPDATE category SET name = :name, description = :description, navigation = :navigation, seo_name = :seo_name WHERE id = :id';//SQL
    $statement = $pdo->prepare($sql);                                  // Prepare
    $statement->bindValue(':id', $category->id, PDO::PARAM_INT);       // Bind id
    $statement->bindValue(':name', $category->name);                   // Bind name
    $statement->bindValue(':description', $category->description);     // Bind description
    $statement->bindValue(':navigation', $category->navigation);       // Bind navigation
    $statement->bindValue(':seo_name', Utilities::createSlug($category->name));       // Bind navigation
    try {
      $statement->execute();
      $result = TRUE;
    } catch (PDOException $error) {                                    // Otherwise
      if ($error->errorInfo[1] == 1062) {                              // If a duplicate
        $result = 'A category with that name exists - try a different name';
      } else {
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
      }
    }
    return $result;
  }

  public function delete($id){
    $pdo = $this->pdo;
    $sql = 'DELETE FROM category WHERE id = :id';                 // SQL
    $statement = $pdo->prepare($sql);                             // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);            // Bind ID
    try {
      $statement->execute();                                      // If executes
      return TRUE;                                                // Say succeeded
    } catch (PDOException $error) {                               // Otherwise
      return $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
    }
  }

  public function getCategoryBySeoName($name)
    {
        $pdo = $this->pdo;
        $sql = 'SELECT * FROM category WHERE seo_name=:seo_name';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':seo_name', $name, PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
        $category = $statement->fetch();
        if (!$category) {
            return null;
        }
        return $category;
    }

}