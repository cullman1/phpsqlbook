<?php
class ArticleManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getHomepageArticleSummaries(){
        $pdo = $this->pdo;
        $sql = 'SELECT article.id, article.title, article.summary, article.created, 
            article.user_id, article.category_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category, media.id as media_id,   
            media.file as media_file, media.alt AS media_alt 
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON articleimages.media_id = media.id
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

    public function getArticleById($id) {
        $pdo = $this->pdo;
        $sql = 'SELECT article.*, 
        user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author, user.profile_image AS author_image, 
        category.id AS category_id, category.name AS category,
	      media.id AS media_id, media.file AS media_file, media.alt AS media_alt
    		FROM article 
    		LEFT JOIN user ON article.user_id = user.id
    		LEFT JOIN category ON article.category_id = category.id
    		        LEFT JOIN articleimages ON articleimages.article_id = article.id
          LEFT JOIN media ON articleimages.media_id = media.id
    		WHERE article.id=:id';                          // Query
        $statement = $pdo->prepare($sql);          // Prepare
        $statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');         $article = $statement->fetch();
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
            media.id as media_id, media.file as media_file, media.alt AS media_alt 
           FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
                    LEFT JOIN articleimages ON articleimages.article_id = article.id
          LEFT JOIN media ON articleimages.media_id = media.id
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



   public function getArticleSummariesByUserId($id) {
       $pdo = $this->pdo;
       $sql = 'SELECT article.id, article.title, article.summary, article.created, article.published, 
           user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author,             category.id AS category_id, category.name AS category, category.seo_name AS seo_category, 
            media.id as media_id, media.file as media_file, media.alt as media_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
            LEFT JOIN articleimages ON articleimages.article_id = article.id
            LEFT JOIN media ON media.id = articleimages.media_id
            WHERE article.user_id=:user_id
            AND category.navigation = TRUE
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

   function getSearchCount($term) {
       $pdo = $this->pdo;                                // Database connection
       $query =  "SELECT COUNT(*) FROM article ";
       $query .= "WHERE ((title LIKE :term)  OR (summary LIKE :term) OR (content LIKE :term)) "; // Query
       $like_term = '%' . $term . '%';                     // Add wildcards to search term
       $statement = $pdo->prepare($query);                 // Prepare 
       $statement->bindParam(':term', $like_term);         // Bind search term
       $statement->execute();                              // Execute
       $article_count = $statement->fetchColumn();         // Return count from function
       if (!$article_count) {
           return null;
       }
       return $article_count;  
   }

   function searchArticles($term) {
       $pdo = $this->pdo;                                  // Database connection
       $sql =  'SELECT article.*, category.name AS category, category.id as category_id,  
             user.id as user_id,  CONCAT(user.forename, " ", user.surname) AS author,     
             media.id as media_id, media.file AS media_file, media.alt AS media_alt 
             FROM article LEFT JOIN user ON article.user_id = user.id
             LEFT JOIN category ON article.category_id = category.id
             LEFT JOIN articleimages ON articleimages.article_id = article.id
             LEFT JOIN media ON media.id = articleimages.media_id 
             WHERE ((title LIKE :term) OR (summary LIKE :term) OR (content LIKE :term)) ORDER BY id DESC ';           
       $like_term = '%' . $term . '%';                     // Add wildcards to search term
       $statement = $pdo->prepare($sql);     // Prepare 
       $statement->bindParam(':term', $like_term);         // Bind search term
       $statement->execute();                              // Execute
       $statement->setFetchMode(PDO::FETCH_CLASS, 'Article');           
       $article_list = $statement->fetchAll();             // Return matches in database
       if (!$article_list) {
           return null;
       }
       //Tamper with results here:
       foreach($article_list as $article) {
           $article->content = $this->showTerm($article->content, $term);
           $article->title = $this->showTerm($article->title, $term);
           $article->summary = $this->showTerm($article->summary, $term);
       }

       return $article_list;
   }

   function showTerm($article_part, $term) {
       $pos_term = mb_strpos($article_part, $term);
       $article_part =str_ireplace($term, "<strong><u>".$term."</u></strong>",  $article_part); 
       return substr( $article_part, $pos_term, 100);
   }

}


