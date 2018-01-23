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
}