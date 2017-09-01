<?php

class CategoryManager
{

  private $pdo;

  /**
   * CategoryManager constructor.
   * @param $pdo
   */
  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  /**
   * @param null $id
   * @return mixed
   */
  public function getNavigationCategories(){
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category WHERE navigation = TRUE';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');
    $category_list = $statement->fetchAll();
    if (!$category_list) {
      return null;
    }
    return $category_list;
  }

  /**
   * @param int $id
   * @return null
   */
  public function getCategoryById($id)
  {
    $pdo = $this->pdo;
    $sql = 'SELECT * FROM category WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');
    $category = $statement->fetch();
    if (!$category) {
      return null;
    }
    return $category;
  }

}