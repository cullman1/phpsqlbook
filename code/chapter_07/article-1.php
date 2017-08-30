<?php
  require_once('includes/config.php');                   // Includes connection

  Class Article {
	public  $id;
	public  $title;
	public  $seo_title;
	public  $content;
	public  $published;
	public  $category_id;
	public  $user_id;
	public  $media_id;
	public  $gallery_id;

	function __construct($id ='', $title = NULL, $content = NULL, $published = NULL, $category_id = NULL, $user_id = NULL, $media_id = NULL, $gallery_id = NULL) {
		$this->id          = ( isset($id)          ? $id          : '');
		$this->title       = ( isset($title)       ? $title       : '');
		$this->content     = ( isset($content)     ? $content     : '');
		$this->published   = ( isset($published)   ? $published   : '');
		$this->category_id = ( isset($category_id) ? $category_id : '');
		$this->user_id     = ( isset($user_id)     ? $user_id     : '');
		$this->media_id    = ( isset($media_id)    ? $media_id    : '');
		$this->gallery_id  = ( isset($gallery_id)  ? $gallery_id  : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO article (title, seo_title, content, category_id, user_id, media_id) 
		        VALUES (:title, :seo_title, :content, :category_id, :user_id, :media_id)';
		$statement = $connection->prepare($sql);                                   // Prepare
		$statement->bindValue(':title',       $this->title);                       // Bind value
		$statement->bindValue(':seo_title',   create_slug($this->title));          // Bind value
		$statement->bindValue(':content',     $this->content);                     // Bind value
		$statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT); // Bind value
		$statement->bindValue(':user_id',     $this->user_id, PDO::PARAM_INT);     // Bind value
		$statement->bindValue(':media_id',    $this->media_id, PDO::PARAM_INT);    // Bind value
		
		try {
			$statement->execute();                                         // Try to execute
			$result = TRUE;                                                // Say worked if it did
		} catch (PDOException $error) {                                    // Otherwise
            if ($error->errorInfo[1] == 1062) {                              // If a duplicate
                $result = 'The article title is too similar to a title that already exists - try a different title.'; // Error
    		} else {                                                         // Otherwise
      		  $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		    }            
		}
		return $result;                                                    
	}

	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE article SET title = :title, seo_title = :seo_title, content = :content, published = :published, category_id = :category_id, user_id = :user_id, media_id = :media_id  WHERE id = :id';//SQL
		$statement = $connection->prepare($sql);                                   // Prepare
		$statement->bindValue(':id',          $this->id, PDO::PARAM_INT);          // Bind value
		$statement->bindValue(':title',       $this->title);                       // Bind value
		$statement->bindValue(':seo_title',   create_slug($this->title));          // Bind value
		$statement->bindValue(':content',     $this->content);                     // Bind value
		$statement->bindValue(':published',   $this->published);                   // Bind value
		$statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT); // Bind value
		$statement->bindValue(':user_id',     $this->user_id,     PDO::PARAM_INT); // Bind value
		$statement->bindValue(':media_id',    $this->media_id,    PDO::PARAM_INT); // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                      // Otherwise
		    if ($error->errorInfo[1] == 1062) {                              // If a duplicate
    		  $result = 'The article title is too similar to a title that already exists - try a different title.'; // Error
    		} else {                                                         // Otherwise
      		  $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		    }                                                                // End if/else
		}
		return $result;                                                      // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM article WHERE id = :id';                       // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		try {
			$statement->execute();                                         // If executes
			return TRUE;                                                   // Say succeeded
		} catch (PDOException $error) {                                    // Otherwise
			return $error->errorInfo[1] . ': ' . $error->errorInfo[2];     // Error
		}
	}
}

  $id = (isset($_GET['id']) ? $_GET['id'] : '');        // Get article id

  $sql = 'SELECT article.*, user.*, 
    media.filepath, media.filename, media.alt, media.mediatype 
    FROM article 
    LEFT JOIN user ON article.user_id = user.id
    LEFT JOIN media ON article.media_id = media.id
    WHERE article.id=:id';                               // Query

  $statement = $pdo->prepare($sql);                      // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT);     // Bind value from query string
  $statement->execute();                                 // Execute
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article'); 
  $article = $statement->fetch(); 
var_dump($article);                                                // Fetch
  if (empty($article)) {
 //      header( "Location: 404.php" );
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $article->title ?></title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php include('includes/header.php'); ?>
    <h1><?= $article->title ?></h1>
    <div class="image">
      <img src="<?= $article->filepath ?><?= $article->filename ?>" 
 alt="<?= $article->alt ?>" type="<?= $article->mediatype ?>">
    </div>
    <div class="content">
      <?= $article->content ?>
      <p class="published"> Created: <?= $article->published ?></p>
      <p class="author">Posted by: <a href="mailto:<?= $article->email ?>">
         <?= $article->forename ?> <?= $article->surname ?></a></p>
    </div>
  </body>
</html>