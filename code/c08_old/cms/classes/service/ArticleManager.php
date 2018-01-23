<?php
class ArticleManager {
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }
  
  public function getAllArticleSummaries($limit=0, $publish=0){
    $pdo = $this->pdo;
    $sql = 'SELECT article.article_id, article.title, article.summary, article.created, 
             article.user_id, article.category_id, article.published,
             CONCAT(user.forename, " ", user.surname) AS author,
             category.name AS category,             
             image.file as image_file, image.alt AS image_alt 
            FROM article
             LEFT JOIN user ON article.user_id = user.user_id 
             LEFT JOIN category ON article.category_id = category.category_id 
             LEFT JOIN articleimage ON articleimage.article_id = article.article_id
             LEFT JOIN image ON articleimage.image_id = image.image_id  
            WHERE category.navigation = TRUE ';
    if ($publish == 0) { 
      $sql .= '  AND article.published = TRUE';
    }
       $sql .= ' GROUP BY article_id ';
      $sql .= ' ORDER BY article.created DESC ';    

    if ($limit != 0) { 
         $sql .= ' LIMIT '. $limit;
    }
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
    $article_list = $statement->fetchAll();
    if (!$article_list) {
      return null;
    }
    return $article_list;
  }

  public function getArticleById($article_id) {
  $pdo = $this->pdo;
  $sql = 'SELECT article.*, 
           CONCAT(user.forename, " ", user.surname) AS author, user.picture AS author_image, 
           category.name AS category, 
           image.image_id AS image_id, 
           image.file AS image_file, image.alt AS imagea_alt    		
          FROM article 
           LEFT JOIN user ON article.user_id = user.user_id
           LEFT JOIN category ON article.category_id = category.category_id
           LEFT JOIN articleimage ON articleimage.article_id = article.article_id
           LEFT JOIN image ON articleimage.image_id = image.image_id
          WHERE article.article_id=:id';                      // Query
  $statement = $pdo->prepare($sql);                   // Prepare
  $statement->bindValue(':id', $article_id, PDO::PARAM_INT);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');          
  $article = $statement->fetch();
  if (!$article) {
    return null;
  }
  return $article;
}

public function getArticleSummariesByCategoryId($category_id){
  $pdo = $this->pdo;
  $sql = 'SELECT article.article_id, article.title, article.summary, article.created, 
          article.user_id, article.category_id, article.published, CONCAT(user.forename, " ", user.surname) AS author,
          category.name AS category,
          image.image_id as image_id, image.file AS image_file, image.alt AS image_alt 
          FROM article
          LEFT JOIN user ON article.user_id = user.user_id 
          LEFT JOIN category ON article.category_id = category.category_id 
          LEFT JOIN articleimage ON articleimage.article_id = article.article_id
          LEFT JOIN image ON articleimage.image_id = image.image_id
          WHERE article.category_id=:category_id 
          AND article.published = TRUE
          ORDER BY article.created DESC';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
  $article_list = $statement->fetchAll();
  if (!$article_list) {
    return null;
  }
  return $article_list;
}

public function getArticleSummariesByUserId($user_id) {
  $pdo = $this->pdo;
  $sql = 'SELECT article.article_id, article.title, article.summary, article.created, 
            article.user_id, article.category_id, article.published,
           CONCAT(user.forename, " ", user.surname) AS author,
           category.name AS category,
           image.image_id as image_id, image.file AS image_file, image.alt AS image_alt 
          FROM article
           LEFT JOIN user ON article.user_id = user.user_id 
           LEFT JOIN category ON article.category_id = category.category_id 
           LEFT JOIN articleimage ON articleimage.article_id = article.article_id
           LEFT JOIN image ON articleimage.image_id = image.image_id            
          WHERE article.user_id=:user_id AND article.published = TRUE
          ORDER BY article.created DESC';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
   $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
  $article_list = $statement->fetchAll();
  if (!$article_list) {
    return null;
  }
  return $article_list;

}

}
