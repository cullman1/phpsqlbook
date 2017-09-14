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

  public function getArticleById($id) {
    $pdo = $this->pdo;
    $sql = 'SELECT article.*, 
        user.id AS user_id, CONCAT(user.forename, " ", user.surname) AS author,  
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

  public function getAllArticleSummaries(){
    $pdo = $this->pdo;
    $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published,
            user.id as user_id, CONCAT(user.forename, " ", user.surname) AS author,
            category.id as category_id, category.name AS category,
            media.id as media_id, media.thumb, media.alt AS thumb_alt
            FROM article
            LEFT JOIN user ON article.user_id = user.id 
            LEFT JOIN category ON article.category_id = category.id 
            LEFT JOIN media ON article.media_id = media.id 
            AND article.published = TRUE
            ORDER BY article.created';
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
    $sql = 'SELECT article.id, article.title, article.summary, article.created, article.user_id, article.category_id, article.media_id, article.published,
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

  public function create($article) {
    $pdo = $this->pdo;
    $sql = 'INSERT INTO article (title, summary, content, category_id, user_id, published) 
		        VALUES (:title, :summary, :content, :category_id, :user_id, :published)';
    $statement = $pdo->prepare($sql);                                             // Prepare
    $statement->bindValue(':title',       $article->title);                       // Bind value
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
    $sql = 'UPDATE article SET title = :title, summary = :summary, content = :content, category_id = :category_id, user_id = :user_id, published = :published WHERE id = :id'; //SQL
    $statement = $pdo->prepare($sql);                                               // Prepare
    $statement->bindValue(':id',          $article->id, PDO::PARAM_INT);            // Bind value
    $statement->bindValue(':title',       $article->title);                         // Bind value
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

  public function moveImage($media, $temporary) {
    $moved = move_uploaded_file($temporary, '../' . UPLOAD_DIR . $media->filename);    // Try to move uploaded file
    if ($moved == FALSE) {
      return 'Could not save image.';
    }
    return TRUE;
  }

  public function saveImage($article_id, $media) {
      $pdo = $this->pdo;
      $pdo->beginTransaction();
      try {
        $sql = 'INSERT INTO media (title,  alt,  filename) 
	     	                  VALUES (:title, :alt, :filename)';
        $statement = $pdo->prepare($sql);                                 // Prepare
        $statement->bindValue(':title',     $media->title);               // Bind value
        $statement->bindValue(':alt',       $media->alt);                 // Bind value
        $statement->bindValue(':filename',  $media->filename);            // Bind value
        $statement->execute();                                            // Try to execute
        $media->id = $pdo->lastInsertId();                                // Add id to object

        $sql = 'INSERT INTO articleimages (article_id,  media_id) 
	    	                           VALUES (:article_id, :media_id)';
        $statement = $pdo->prepare($sql);                                 // Prepare
        $statement->bindValue(':article_id', $article_id);               // Bind value
        $statement->bindValue(':media_id',   $media->id);                 // Bind value
        $statement->execute();                                         // Try to execute

        $pdo->commit();
        $result = TRUE;
      } catch (PDOException $error) {                                  // Otherwise
        $pdo->rollBack();
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error <-- cannot show this
      }
    return $result;
  }

  public function createThumbnailGD($media, $new_width, $new_height) {
    $current_image  = '../' . UPLOAD_DIR . $media->filename;            // Path to current image
    $thumbpath      = '../' . UPLOAD_DIR . 'thumb/' . $media->filename; // Path to thumbnail
    $image_details  = getimagesize($current_image);              // Get file information
    $file_type      = $image_details['mime'];                    // Get image type
    $current_width  = $image_details[0];                         // Get width
    $current_height = $image_details[1];                         // Get height
    $ratio          = $current_width / $current_height;          // Get ratio of image
    $new_ratio      = $new_width / $new_height;                  // Get ratio of thumb

    if ($new_ratio > $ratio) {                                   // If new is greater
      $new_width    = $new_height * $ratio;                      // Set new width
    } else {                                                     // Else
      $new_height   = $new_width / $ratio;                       // Set new height
    }

    switch($file_type) {
      case 'image/gif':
        $current_image = imagecreatefromgif($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagegif($new_image, $thumbpath);                               // Save image
        return TRUE;
      case 'image/png':
        $current_image = imagecreatefrompng($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagepng($new_image, $thumbpath);                               // Save image
        return TRUE;
      default:
        $current_image = imagecreatefromjpeg($current_image);           // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagejpeg($new_image, $thumbpath);                              // Save image
        return TRUE;
    }
    return 'Could not create thumbnail.';
  }

  public function create_slug($title) {
    $title = strtolower($title);
    $title = trim($title);
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
  }

  function sanitize_file_name($file) {
    $file = preg_replace('([^\w\d\-_~,;.])','',$file);
    $file = preg_replace('([\~,;])', '-', $file);
    return $file;
  }

}