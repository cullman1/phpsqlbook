<?php
class CategoryManager {

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

    public function getCategoryById($id) :?Category {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category WHERE category_id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category = $statement->fetch();
      return $category ?:NULL;
  }

    public function getNavigationCategories() :array {
    $pdo = $this->pdo;
    $sql = 'SELECT DISTINCT category.*
            FROM category 
            INNER JOIN article ON article.category_id = category.category_id
            WHERE navigation = TRUE';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    $category_list = $statement->fetchAll();
        return $category_list ?? null;
  }
}