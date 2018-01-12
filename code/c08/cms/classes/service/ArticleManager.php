<?php
class ArticleManager {
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }
  
  public function getAllArticleSummaries($limit=0, $publish=0){
    $pdo = $this->pdo;
    $sql = 'SELECT article.id, article.title, article.summary, article.created, 
            article.user_id, article.category_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,             
            media.id as media_id, media.file as media_file, media.alt AS media_alt 
            
            FROM article
            
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN articleimage ON articleimage.article_id = article.id
            LEFT JOIN media ON articleimage.media_id = media.id
      
            WHERE category.navigation = TRUE ';
    if ($publish == 0) { 
      $sql .= '  AND article.published = TRUE';
    }
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

  public function getArticleById($id) {
  $pdo = $this->pdo;
  $sql = 'SELECT article.*, user.id AS user_id, 
          CONCAT(user.forename, " ", user.surname) AS author, 
          user.profile_image AS author_image, category.id AS category_id, 
          category.name AS category, media.id AS media_id, 
          media.file AS media_file, media.alt AS media_alt    		
          FROM article 
          LEFT JOIN user ON article.user_id = user.id
          LEFT JOIN category ON article.category_id = category.id
          LEFT JOIN articleimage ON articleimage.article_id = article.id
          LEFT JOIN media ON articleimage.media_id = media.id
          WHERE article.id=:id';                      // Query
  $statement = $pdo->prepare($sql);                   // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');          
  $article = $statement->fetch();
  if (!$article) {
    return null;
  }
  return $article;
}

public function getArticleSummariesByCategoryId($id){
  $pdo = $this->pdo;
  $sql = 'SELECT article.id, article.title, article.summary, article.created, 
          article.user_id, article.category_id, article.published,
          user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
          category.id as category_id, category.name AS category,
          media.id as media_id, media.file AS media_file, media.alt AS media_alt 
          FROM article
          LEFT JOIN user ON article.user_id = user.id 
          LEFT JOIN category ON article.category_id = category.id 
          LEFT JOIN articleimage ON articleimage.article_id = article.id
          LEFT JOIN media ON articleimage.media_id = media.id
          WHERE article.category_id=:category_id 
          AND article.published = TRUE
          ORDER BY article.created DESC';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':category_id', $id, PDO::PARAM_INT);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
  $article_list = $statement->fetchAll();
  if (!$article_list) {
    return null;
  }
  return $article_list;
}

public function getArticleSummariesByUserId($id) {
  $pdo = $this->pdo;
  $sql = 'SELECT article.id, article.title, article.summary, article.created, 
            article.user_id, article.category_id, article.published,
          user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
          category.id as category_id, category.name AS category,
          media.id as media_id, media.file AS media_file, media.alt AS media_alt 
          FROM article
          LEFT JOIN user ON article.user_id = user.id 
          LEFT JOIN category ON article.category_id = category.id 
          LEFT JOIN articleimage ON articleimage.article_id = article.id

          LEFT JOIN media ON articleimage.media_id = media.id            
          WHERE article.user_id=:user_id 
          AND article.published = TRUE
          ORDER BY article.created DESC';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $id, PDO::PARAM_INT);
   $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
  $article_list = $statement->fetchAll();
  if (!$article_list) {
    return null;
  }
  return $article_list;

}

}
