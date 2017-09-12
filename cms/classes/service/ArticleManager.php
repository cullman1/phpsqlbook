<?php

class ArticleManager{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getHomepageArticleSummaries(){
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,
            media.id as media_id, media.thumb, media.alt AS thumb_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN media ON article.media_id = media.id 
            WHERE category.navigation = TRUE 
            AND article.published = TRUE
            ORDER BY article.created DESC 
            LIMIT 9';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'ArticleSummary');
        $article_list = $statement->fetchAll();
        if (!$article_list) {
            return null;
        }
        return $article_list;
    }

    public function getArticleSummariesByCategoryId($id){
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published, article.like_count, article.comment_count,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,
            media.id as media_id, media.thumb, media.alt AS thumb_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN media ON article.media_id = media.id 
            WHERE article.category_id=:category_id 
            AND article.published = TRUE
            ORDER BY article.created';
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

    public function getArticleSummariesByCategorySeoName($title, $show='', $from='0'){
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published,article.seo_title,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,
            media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype, article.like_count, article.comment_count ';
        if (isset($_SESSION['user_id'])) {
            $sql .= ', COALESCE( (SELECT 1 FROM likes WHERE likes.user_id=' . 
                          $_SESSION['user_id'] . ' AND likes.article_id = article.id), 0) 
                  AS liked ';
        }
        $sql .= 'FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN media ON article.media_id = media.id 
            WHERE category.seo_name=:seo_name 
            AND article.published = TRUE
            ORDER BY article.created';
        if (!empty($show)) {             // If value given for $show add 
            $sql .= " LIMIT " . $show . " OFFSET " . $from;
        }
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':seo_name', $title, PDO::PARAM_INT);
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
        user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author, user.image AS author_image, 
        category.id AS category_id, category.name AS category,
	      media.id AS media_id, media.filepath AS media_filepath, media.alt AS media_alt
    		FROM article 
    		LEFT JOIN user ON article.user_id = user.id
    		LEFT JOIN category ON article.category_id = category.id
    		LEFT JOIN media ON article.media_id = media.id
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
        $sql = 'SELECT article.*, user.id AS user_id, COALESCE(user.forename, user.surname) as author, 
              user.email, user.image, media.filepath, media.filename, media.alt, category.name as category,
              media.mediatype, media.thumb '; 
           if (isset($_SESSION['user_id'])) {
               $sql .= ', COALESCE( (SELECT 1 FROM likes WHERE likes.user_id=' . 
                  $_SESSION['user_id'] . ' AND likes.article_id = article.id), 0) 
                  AS liked ';
  }
           $sql .= 'FROM article
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
 LEFT JOIN category ON article.category_id = category.id
      WHERE article.seo_title=:seo_title';            // Query
           $statement = $pdo->prepare($sql);          // Prepare
        $statement->bindValue(':seo_title', $seo_title);    // Bind value from query string
        if ($statement->execute() ) {
            $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');
            $article = $statement->fetch();
        }
        if ($article) {
            return $article;
        } else {
            return FALSE;
        }
    }

    function getAllArticleSummaries($show='', $from='0') {
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,
            media.id as media_id, media.thumb, media.alt AS thumb_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN media ON article.media_id = media.id 
            WHERE article.published = TRUE
            ORDER BY article.created';
        if (!empty($show)) {             // If value given for $show add 
            $sql .= " LIMIT " . $show . " OFFSET " . $from;
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

    function getArticleCountByCategorySeoName($name) {
        $pdo  = $this->pdo;
        $query = 'SELECT COUNT(*)  FROM category 
            INNER JOIN article ON article.category_id = category.id
            WHERE  seo_name=:name AND published = true';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $count= $statement->fetchColumn();
        return $count;
    }

    public function create($article) {
        $pdo = $this->pdo;
        $sql = 'INSERT INTO article (title, seo_title summary, content, category_id, user_id, published ) 
		        VALUES (:title, :seo_title, :summary, :content, :category_id, :user_id, :published)';
        $statement = $pdo->prepare($sql);                                             // Prepare
        $statement->bindValue(':title',       $article->title);                       // Bind value
        $statement->bindValue(':seo_title',   $this->createSlug($this->title));    // Bind value
        $statement->bindValue(':summary',     $article->summary);                     // Bind value
        $statement->bindValue(':content',     $article->content);                     // Bind value
        $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT); // Bind value
        $statement->bindValue(':user_id',     $article->user_id, PDO::PARAM_INT);     // Bind value
        $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);   // Bind value

        try {
            $statement->execute();                                         // Try to execute
            $article->id = $pdo->lastInsertId();                                // Add id to object
            $result = TRUE;                                                // Say worked if it did
        }
        catch (PDOException $error) {                                  // Otherwise
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
        $statement->bindValue(':seo_title',   $this->createSlug($this->title));    // Bind value
        $statement->bindValue(':summary',     $article->summary);                        // Bind value
        $statement->bindValue(':content',     $article->content);                       // Bind value
        $statement->bindValue(':category_id', $article->category_id, PDO::PARAM_INT);   // Bind value
        $statement->bindValue(':user_id',     $article->user_id,     PDO::PARAM_INT);   // Bind value
        $statement->bindValue(':published',   $article->published, PDO::PARAM_BOOL);   // Bind value
        try {
            $statement->execute();
            $result = TRUE;
        }
        catch (PDOException $error) {                                      // Otherwise
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
        }
        catch (PDOException $error) {                               // Otherwise
            return $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
        }
    }

    public function createSlug($title) {
        $title = strtolower($title);
        $title = trim($title);
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
    }

    function createPagination($count, $show, $from) {
        $total_pages  = ceil($count / $show);       // Total matches
        $current_page = ceil($from / $show) + 1;    // Current page
        $result  = '<div class="pagination">';
        if ($total_pages > 1) {
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    $result .= $i . '&nbsp;';
                } else {
                    $result .= '<a href="?show=' . $show . '&from=' . (($i-1) * $show) . '">';
                    $result .= $i . '</a>&nbsp;';
                }
            }
        }
        $result .= '</div>';
        return $result ;
    }

    function addLikeById($user_id, $article_id) {
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
        }
        catch (PDOException $error) {
            $pdo->rollback();
            return 'Article ' .$article_id . ' was not liked. Error: ' . $error->getMessage();
        }
    }

    function removeLikeById($user_id, $article_id) {
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
        }
        catch (PDOException $error) {                               
            $pdo->rollback();
            return 'Article ' .$article_id . ' was not unliked. Error: ' . $error->getMessage();
        }
    }
   
    function getArticleUrl($article_id) {
        $pdo = $this->pdo;
        $sql = 'SELECT category.seo_name, article.seo_title FROM article
            LEFT JOIN category ON article.category_id = category.id
            WHERE article.id=:id';
        $statement = $pdo->prepare($sql);          
        $statement->bindValue(':id', $article_id);    
        if ($statement->execute() ) {
            $statement->setFetchMode(PDO::FETCH_OBJ);     
            $titles = $statement->fetch();
        }
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
            $sql = 'INSERT INTO comment (comment, article_id, user_id, posted, reply_to_id, parent_id) 
              VALUES  (:comment, :article_id, :user_id, :date, :reply_to_id, :parent_id)';
            $statement = $pdo->prepare($sql);         // Connection + prepare
            $statement->bindParam(':comment',$comment->comment);             // Bind parameter
            $statement->bindParam(':article_id',$comment->article_id);       // Bind parameter
            $statement->bindParam(':user_id',$comment->user_id);             // Bind parameter
            $date = date('Y-m-d H:i:s');                                  // Set date + time
            $statement->bindParam(':date',$date);                         // Bind date + time
            $statement->bindParam(':reply_to_id',$comment->reply_to_id);     // Bind parameter
            $statement->bindParam(':parent_id',$comment->parent_id);         // Bind parameter
            $statement->execute();                                        // Execute query
            $sql='UPDATE article SET comment_count = comment_count + 1 WHERE id = :article_id';
            $statement = $pdo->prepare($sql);         // Connect + prepare
            $statement->bindValue(':article_id',  $comment->article_id);     // Bind parameter 
            $statement->execute();                                        // Execute query
            $pdo->commit();                             // Commit changes
            return TRUE;                                                  // Return TRUE
        }
        catch (PDOException $error) {                                 // If an error
            $pdo->rollback();    
            echo $error;
            // Undo changes
            return $error;           // Return error
        }
    }

    public function getCommentsByArticleId($id) {
        $pdo = $this->pdo;
        $sql = 'SELECT comment.*, 
            CONCAT(user.forename, " ", user.surname) as author, user.image 
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

}