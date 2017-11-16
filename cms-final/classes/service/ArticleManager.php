<?php

class ArticleManager{

  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

    public function getAllArticleSummaries($limit=0){
    $pdo = $this->pdo;
    $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category, media.id as media_id,  media.file as media_file, media.alt AS media_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
              LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON media.id = articleimages.media_id
            LEFT JOIN category ON article.category_id = category.id 
            AND article.published = TRUE
             GROUP BY id
            ORDER BY article.created DESC ';
    if ($limit!=0) { 
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
    $sql = 'SELECT article.*, 
        user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author,  
        category.id AS category_id, category.name AS category 
    		FROM article 
    		LEFT JOIN user ON article.user_id = user.id
    		LEFT JOIN category ON article.category_id = category.id
    		WHERE article.id=:id';                          // Query
    $statement = $pdo->prepare($sql);          // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
    $article = $statement->fetch();
    if (!$article) {
      return null;
    }
    return $article;
  }

  public function getArticleBySeoTitle($seo_title) {
    $pdo = $this->pdo;
    $sql = 'SELECT article.*, CONCAT(user.forename, " ", user.surname) AS author, 
user.seo_name AS seo_user, category.id AS category_id, category.name AS category ';
        if (isset($_SESSION['user_id'])) {
        $sql .= ', COALESCE( (SELECT max(1) FROM likes WHERE likes.user_id=' .
                  $_SESSION['user_id'] . ' AND likes.article_id = article.id), 0) 
                  AS liked ';
        }
        $sql .= 'FROM article
    		LEFT JOIN user ON article.user_id = user.id
    		LEFT JOIN category ON article.category_id = category.id
    		WHERE article.seo_title=:seo_title';    
    $statement = $pdo->prepare($sql);          // Prepare
    $statement->bindValue(':seo_title', $seo_title);  // Bind value from query string
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
    $article = $statement->fetch();
    if (!$article) {
      return null;
    }
    return $article;
  }



  

  public function getArticleSummariesByUserId($id){
    $pdo = $this->pdo;
    $sql = 'SELECT article.id, article.title, article.summary, article.created, article.published, article.seo_title,
            article.like_count, article.comment_count,
            user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author, user.seo_name AS seo_user,
            category.id AS category_id, category.name AS category, category.seo_name AS seo_category, 
            media.id as media_id, media.file as media_file, media.alt as media_alt

            FROM article

            LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON media.id = articleimages.media_id

            WHERE article.user_id=:user_id
            AND category.navigation = TRUE
            AND article.published = TRUE
            GROUP BY id
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

  public function create($article) {
    $pdo = $this->pdo;
    $sql = 'INSERT INTO article (title,  seo_title,  summary,  content,  category_id,  user_id,  published) 
		                    VALUES (:title, :seo_title, :summary, :content, :category_id, :user_id, :published)';
    $statement = $pdo->prepare($sql);                                             // Prepare
    $statement->bindValue(':title',       $article->title);                       // Bind value
    $statement->bindValue(':seo_title',   Utilities::createSlug($article->title));    // Bind value
    $statement->bindValue(':summary',     $article->summary);                     // Bind value
    $statement->bindValue(':content',     $article->content);                     // Bind value
    $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT); // Bind value
    $statement->bindValue(':user_id',     $article->user_id, PDO::PARAM_INT);     // Bind value
    $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);  // Bind value
    try {
      $statement->execute();                                         // Try to execute
      $article->id = $pdo->lastInsertId();                           // Add id to object
      $result = TRUE;                                                // Say worked if it did
    } catch (PDOException $error) {                                  // Otherwise
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error <-- cannot show this
    }
    return $result;
  }

  public function update($article){
    $pdo = $this->pdo;
    $sql = 'UPDATE article SET title = :title, seo_title = :seo_title, summary = :summary, content = :content, category_id = :category_id, user_id = :user_id, published = :published WHERE id = :id'; //SQL
    $statement = $pdo->prepare($sql);                                               // Prepare
    $statement->bindValue(':id',          $article->id, PDO::PARAM_INT);            // Bind value
    $statement->bindValue(':title',       $article->title);                         // Bind value
    $statement->bindValue(':seo_title',   Utilities::createSlug($article->title));
    $statement->bindValue(':summary',     $article->summary);                        // Bind value
    $statement->bindValue(':content',     $article->content);                       // Bind value
    $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT);   // Bind value
    $statement->bindValue(':user_id',     $article->user_id,     PDO::PARAM_INT);   // Bind value
    $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);   // Bind value
    try {
      $statement->execute();
      $result = TRUE;
    } catch (PDOException $error) {                                      // Otherwise
      if ($error->errorInfo[1] == 1062) {                              // If a duplicate
        $result = 'An article with that title exists - try a different title.'; // Error
      } else {                                                         // Otherwise
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
      }                                                                // End if/else
    }
    return $result;
  }

  public function delete($id){
    $pdo = $this->pdo;
    $sql = 'DELETE FROM article WHERE id = :id';                 // SQL
    $statement = $pdo->prepare($sql);                             // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);            // Bind ID
    try {
      $statement->execute();                                      // If executes
      return TRUE;                                                // Say succeeded
    } catch (PDOException $error) {                               // Otherwise
      return $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
    }
  }

  public function getArticleImages($id){
    $pdo = $this->pdo;
    $sql = 'SELECT articleimages.*, media.* 
    		FROM articleimages 
    		LEFT JOIN media ON articleimages.media_id = media.id
    		WHERE articleimages.article_id=:id';                    // Query
    $statement = $pdo->prepare($sql);                   // Prepare
    $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Media');     // Object
    $image_list = $statement->fetchAll();
    if (!$image_list) {
      return null;
    }
    return $image_list;
  }

  public function getArticleCountByCategorySeoName($name) {
   $pdo  = $this->pdo;
   $sql = 'SELECT COUNT(*) FROM category 
           INNER JOIN article ON article.category_id = category.id
           WHERE  seo_name=:name AND published = true';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':name', $name);
  $statement->execute();
  return $statement->fetchColumn();
} 

  public function getArticleSummariesByCategorySeoName($title, $show='9', $from='0'){
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, article.published, article.seo_title,
            article.comment_count, article.like_count,
            user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author, user.seo_name AS seo_user, 
            category.id AS category_id, category.name AS category, category.seo_name AS seo_category, 
            media.id as media_id, media.file as media_file, media.alt as media_alt

            FROM article

            LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON media.id = articleimages.media_id
            
            WHERE category.seo_name=:seo_name 
            AND article.published = TRUE
            GROUP BY id
            ORDER BY article.created DESC';
        if (!empty($show)) {             // If value given for $show add 
            $sql .= " LIMIT " . $show . " OFFSET " . $from;
        }
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':seo_name', $title);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
        $article_list = $statement->fetchAll();
        if (!$article_list) {
            return null;
        }
        return $article_list;
    }

   public function getLikeStatus($user_id, $article_id){
    $pdo = $this->pdo;
    $sql = 'SELECT count(*) FROM likes WHERE article_id = :article_id AND user_id = :user_id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();
    $count = $statement->fetchColumn();
    if ($count>0) {
      return FALSE;
    }
    return TRUE;
  }

  public function addLikeById($user_id, $article_id) {
  $pdo = $this->pdo;
  try {       
    $pdo->beginTransaction();  
    $sql = 'INSERT INTO likes (user_id, article_id) VALUES (:user_id, :article_id)';  
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();
    $sql= 'UPDATE article SET like_count = like_count + 1 WHERE id = :article_id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();
    $pdo->commit();
    return TRUE;
  } catch (PDOException $error) {
    $pdo->rollback();
    return 'Article ' .$article_id . ' was not liked. Error: ' . $error->getMessage();
  }
}

  public function removeLikeById($user_id, $article_id) {
  $pdo = $this->pdo;
  try {       
    $pdo->beginTransaction();  
    $sql = 'DELETE FROM likes WHERE user_id= :user_id AND article_id= :article_id';               
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $user_id);  
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
    $sql = 'UPDATE article SET like_count = like_count - 1 WHERE id = :article_id';
    $statement = $pdo->prepare($sql);   
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
    $pdo->commit();     
    return TRUE;
  } catch (PDOException $error) {                               
    $pdo->rollback();
    return 'Article ' .$article_id . ' was not unliked. Error: ' . $error->getMessage();
  }
}

  public function getArticleUrl($article_id) {
  $pdo = $this->pdo;
  $sql = 'SELECT category.seo_name, article.seo_title FROM article
          LEFT JOIN category ON article.category_id = category.id
          WHERE article.id=:id';
  $statement = $pdo->prepare($sql);          
  $statement->bindValue(':id', $article_id);    
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);     
  $titles = $statement->fetch();
  if ($titles) {
    return $titles->seo_name . '/' . $titles->seo_title;
  } else {
    return FALSE;
  }
}

  public function addComment($comment) {
  $pdo = $this->pdo;
  try {
    $pdo->beginTransaction();                   // Begin transaction
    $sql = 'INSERT INTO comment (comment, article_id, user_id, posted, reply_to_id,  
    parent_id) VALUES  (:comment, :article_id, :user_id, :date, :reply_to_id, :parent_id)';
    $statement = $pdo->prepare($sql);         // Connection + prepare
    $statement->bindValue(':comment',$comment->comment);             // Bind parameter
    $statement->bindValue(':article_id',$comment->article_id);       // Bind parameter
    $statement->bindValue(':user_id',$comment->user_id);             // Bind parameter
    $date = date('Y-m-d H:i:s');                                  // Set date + time
    $statement->bindValue(':date',$date);                         // Bind date + time
    $statement->bindValue(':reply_to_id',$comment->reply_to_id);     // Bind parameter
    $statement->bindValue(':parent_id',$comment->parent_id);         // Bind parameter
    $statement->execute();                                        // Execute query
    $sql='UPDATE article SET comment_count = comment_count + 1 WHERE id = :article_id';
    $statement = $pdo->prepare($sql);         // Connect + prepare
    $statement->bindValue(':article_id',  $comment->article_id);     // Bind parameter 
    $statement->execute();                                        // Execute query
            $pdo->commit();                             // Commit changes
            return TRUE;                                                  // Return TRUE
        }
        catch (PDOException $error) {                                 // If an error
            $pdo->rollback();                           // Undo changes
            echo $error;
            return FALSE;           // Return error
    }
 }

  public function getCommentsByArticleId($id) {
  $pdo = $this->pdo;
  $sql = 'SELECT comment.*, 
          CONCAT(user.forename, " ", user.surname) as author  
          FROM comment 
          JOIN user ON comment.user_id = user.id   
          WHERE article_id = :id 
          ORDER BY posted ASC';  
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id, PDO::PARAM_INT); 
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');
  $comments_list = $statement->fetchAll(); 
  if ($comments_list) {
    return $comments_list;
  } else {
    return FALSE; 
  }
}

  public function getCommentsAndRepliesByArticleId($id) {
  $pdo = $this->pdo;
  $sql = 'SELECT comment.*, comment.reply_to_id AS reply_to_copy,
          CONCAT(user.forename, " ", user.surname) AS author,  
          (SELECT CONCAT(user.forename, " ", user.surname) FROM user 
          JOIN comment ON user.id = comment.user_id
          WHERE comment.id = reply_to_copy) 
          AS reply_to
          FROM comment
          JOIN user ON comment.user_id = user.id 
          WHERE article_id = :id 
          ORDER BY posted DESC';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);      
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');          
  $comments_list = $statement->fetchAll();
  if ($comments_list) {
    return $comments_list;
  } else {
    return FALSE; 
  }
}

  public function sortComments($comment_list) {
    $comment_list_reversed = array_reverse($comment_list);
    $nested_comments       = array();
    foreach ($comment_list as $comment) {
      if ($comment->parent_id == 0) {
        array_push($nested_comments, $comment);
        foreach ($comment_list_reversed as $reply) {
          if ($reply->parent_id == $comment->id) {
            array_push($nested_comments, $reply);
          }
        }
      }
    }
    return $nested_comments;
  }

}