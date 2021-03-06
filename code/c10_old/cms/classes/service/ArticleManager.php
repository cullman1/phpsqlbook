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
            WHERE category.navigation = TRUE';
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

  public function getArticleById($article_id) {
  $pdo = $this->pdo;
  $sql = 'SELECT article.*, 
           CONCAT(user.forename, " ", user.surname) AS author, 
           user.picture AS author_image, 
           category.name AS category, 
           image.image_id AS image_id, image.file AS image_file, image.alt AS imagea_alt    
          FROM article 
           LEFT JOIN user ON article.user_id = user.user_id
           LEFT JOIN category ON article.category_id = category.category_id
           LEFT JOIN articleimage ON articleimage.article_id = article.article_id
           LEFT JOIN image ON articleimage.image_id = image.image_id
          WHERE article.article_id=:id';                     // Query
  $statement = $pdo->prepare($sql);                          // Prepare
  $statement->bindValue(':id', $article_id, PDO::PARAM_INT); // Bind value   
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
          article.user_id, article.category_id, article.published, 
          CONCAT(user.forename, " ", user.surname) AS author, 
          category.name AS category_name,  category.description AS category_description,
           image.file AS image_file, image.alt AS image_alt 
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

public function getArticleSummariesByUserId($user_id){
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
              WHERE article.user_id=:user_id 
          AND article.published = TRUE
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

function getSearchCount($term) {
    $pdo = $this->pdo;
    $like_term = '%' . $term . '%';
    $sql = 'SELECT COUNT(*) FROM article
            WHERE ((title LIKE :term) OR (summary LIKE :term) OR (content LIKE :term))
     AND article.published = TRUE';
    $statement = $pdo->prepare($sql);                   // Prepare 
    $statement->bindParam(':term', $like_term);         // Bind search term
    $statement->execute();                              // Execute
    return $statement->fetchColumn();                   // Return count from function
  }
  
  function searchArticles($term) {
    $pdo = $this->pdo;
    $like_term = '%' . $term . '%'; 
    $sql = 'SELECT article.*, category.name AS category, 
             CONCAT(user.forename, " ", user.surname) AS author,
             image.file AS image_file, image.alt AS image_alt
            FROM article 
             LEFT JOIN user ON article.user_id = user.user_id
             LEFT JOIN category ON article.category_id = category.category_id
             LEFT JOIN articleimage ON articleimage.article_id = article.article_id
             LEFT JOIN image ON image.image_id = articleimage.image_id
            WHERE ((title LIKE :term) OR (summary LIKE :term) OR (content LIKE :term))
              AND article.published = TRUE
             GROUP BY title';           
    $statement = $pdo->prepare($sql);                   // Prepare 
    $statement->bindParam(':term', $like_term);         // Bind search term
    $statement->execute();                              // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');          
    $article_list = $statement->fetchAll();             // Return matches in database
    if ($article_list) {
      foreach($article_list as $article) {
        $article->title   = $this->showTerm(Utilities::clean($article->title), $term);
        $article->summary = $this->showTerm(Utilities::clean($article->summary), $term);
      }
      return $article_list; 
    }
    return null;
  }

  function showTerm($text, $term) {
    $pos_term = ((mb_strpos($text, $term)-50) > 0 ? (mb_strpos($text, $term)-50) : 0);
    $text = preg_replace("/$term/i", "<strong><u>$0</u></strong>", $text);   
    return substr($text, $pos_term, 100);
  }

  public function create($article) {
  $pdo = $this->pdo;
  $sql = 'INSERT INTO article (title, summary, content, category_id, user_id, published)    
          VALUES (:title, :summary, :content, :category_id, :user_id, :published)';
  $statement = $pdo->prepare($sql);                                
  $statement->bindValue(':title',       $article->title);          
  $statement->bindValue(':summary',     $article->summary);                     
  $statement->bindValue(':content',     $article->content);                     
  $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT); 
  $statement->bindValue(':user_id',     $article->user_id, PDO::PARAM_INT);     
  $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);        
  try {
      $statement->execute();                                         // Try to execute
      $article->id = $pdo->lastInsertId();                           // Add id to object
      return TRUE;                                                   // Say it worked
  } catch (PDOException $error) {                                    // Otherwise
    if ($error->errorInfo[1] == 1062) {                              // If a duplicate
      return 'An article with that title exists - try a different title.'; // Error
    } else {                                                         // Otherwise
      return $error->errorInfo[1] . ': ' . $error->errorInfo[2];     // Error
    }        
  }  
}

public function update($article){
  $pdo = $this->pdo;     
  $sql = 'UPDATE article SET title = :title, content = :content, summary = :summary,
          category_id = :category_id, user_id = :user_id, published = :published 
          WHERE article_id = :article_id';
  $statement = $pdo->prepare($sql);                                    // Prepare
  $statement->bindValue(':article_id',  $article->article_id, PDO::PARAM_INT); 
  $statement->bindValue(':title',       $article->title);              // Bind value
  $statement->bindValue(':content',     $article->content);            // Bind value
  $statement->bindValue(':summary',     $article->summary);            // Bind value
  $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT); // Bind
  $statement->bindValue(':user_id',     $article->user_id,     PDO::PARAM_INT); // Bind
  $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);  // Bind
  try {                                                                // Try block
    $statement->execute();                                             // Execute SQL
    return TRUE;                                                       // Success
  } catch (PDOException $error) {                                      // Otherwise
     return $error->errorInfo[1] . ': ' . $error->errorInfo[2];        // Error 
  }
}

  }