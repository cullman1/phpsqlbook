<?php

// Category functions
function get_category_by_id($id) {
	$connection = $GLOBALS['connection'];
	$query = 'SELECT * FROM category WHERE id=:id';     // Query
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Category');     // Object   --- do this because of constructor having defaults (see https://www.electrictoolbox.com/php-pdo-fetch-class-gotcha/)
		$Category = $statement->fetch();                // Fetch
	}
	if ($Category) {
		return $Category;
	} else {
	  return FALSE;
  }
}

function get_category_by_name($name) {
	$connection = $GLOBALS['connection'];
    $query = 'SELECT name FROM category 
              WHERE LOWER(name) = LOWER(:name)';        // Query
	$statement = $connection->prepare($query); 
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':name', $name);              // Bind value
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Category');     // Object
		$Category = $statement->fetch();                // Fetch
	}
	if ($Category) {
		return $Category;
	} else {
	    return FALSE;
    }
}

function get_category_list() {
  $connection = $GLOBALS['connection'];       // Connection
  $query = 'SELECT * FROM category';          // Query
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();    // Step 4 Get all rows ready to display
  return $category_list;
}

function create_category_dropdown($id) {
  $category_list = get_category_list();
  $dropdown = '<select name="category_id" id="category_id"class="form-control" >';
  foreach ($category_list as $category) { 
    $dropdown .= '<option value="' . $category->id . '"';
    if ($id === $category->id) {
      $dropdown .= ' selected';
    }
    $dropdown .= '>' . $category->name . '</option>';
  }
  $dropdown .= '</select>';
  return $dropdown;
}


// Article functions

function get_article_by_id($id) {
  // This had conflicts for the id colum in article and user
	$connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, user.id AS user_id, user.forename, user.surname, user.email, user.image, 
      media.filepath, media.filename, media.alt, media.mediatype, media.thumb, galleryitems.gallery_id 
      FROM article 
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
       LEFT JOIN galleryitems ON media.id = galleryitems.gallery_id
      WHERE article.id=:id';                          // Query
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
		$Article = $statement->fetch();
	}
	if ($Article) {
		return $Article;
	} else {
	  return FALSE;
  }
}

function get_article_by_seo_title($seo_title) {
  // This had conflicts for the id colum in article and user
  $connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, user.id AS user_id, user.forename, user.surname, user.email, user.image, 
      media.filepath, media.filename, media.alt, media.mediatype, media.thumb 
      FROM article 
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.seo_title=:seo_title';            // Query
  $statement = $connection->prepare($query);          // Prepare
  $statement->bindValue(':seo_title', $seo_title);    // Bind value from query string
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
    $Article = $statement->fetch();
  }
  if ($Article) {
    return $Article;
  } else {
    return FALSE;
  }
}

function get_article_by_title($title) {
	$connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, user.*, 
      media.filepath, media.filename, media.alt, media.mediatype 
      FROM article 
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.title=:title';                             // Query
	$statement = $connection->prepare($query); 
	$statement->bindValue(':title', $title);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
		$Article = $statement->fetch();
	}
	if ($Article) {
		return $Article;
	} else {
	    return FALSE;
    }
}

/*function get_article_list($category_id='') { // Should there be a separate by_id() function???
 try {
  $connection = $GLOBALS['connection'];
  $id_present = ((is_numeric($category_id)) ? $category_id : FALSE);
  $query = 'SELECT article.id, article.title, article.media_id, article.published,
      media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype
      FROM article
      LEFT JOIN media ON article.media_id = media.id ';
        if ($id_present) {
   $query .= '    WHERE article.category_id=:category_id ';
   }
    $query .= '   ORDER BY article.published';                 // Query
  $statement = $connection->prepare($query); 
  if ($id_present) {
    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);  // Bind value from query string
  }
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to return an articlelist object
  $article_list = $statement->fetchAll();
  return $article_list;
  } catch (PDOException $ex) {
   var_dump($ex);
  }

}*/

function get_article_list($show='', $from='') {
    $query = 'SELECT article.title, article.media_id,article.like_count, article.seo_title,article.content, article.published, category.name,
      media.id, media.filepath, media.thumb, media.alt, media.mediatype,  user.forename, user.surname, article.id, article.like_count, article.comment_count
      FROM article
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      LEFT JOIN user ON article.user_id = user.id
      WHERE published < 1 
      ORDER BY article.published ASC';                 // Query
    
    //Get limited page of articles
    if (!empty($show)) {
        $query .= " limit " . $show . " offset " . $from;
    }
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ); 
    $article_list = $statement->fetchAll();
    return $article_list;
}

function get_article_list_by_category_name($seo_name){ 
  $connection = $GLOBALS['connection'];
  $id_present = ( (is_numeric($id)) ? $id : FALSE);
  $query = 'SELECT article.id, article.title, article.media_id, article.published,
      media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype
      FROM article
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.seo_name=:seo_name
      ORDER BY article.published';                 // Query
  $statement = $connection->prepare($query); 
  $statement->bindValue(':seo_name', $seo_name);  // Bind value from query string
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
  $article_list = $statement->fetchAll();
  return $article_list;
}

function get_article_list_by_author_name($seo_name) {
  $connection = $GLOBALS['connection'];
  $id_present = ( (is_numeric($id)) ? $id : FALSE);
  $query = 'SELECT article.id, article.title, article.media_id, article.published,
      media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype, , article.like_count, article.comment_count
      FROM article
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.seo_name=:seo_name
      ORDER BY article.published';                 // Query NEEDS UPDATING TO USE AUTHOR NAME
  $statement = $connection->prepare($query); 
  $statement->bindValue(':seo_name', $seo_name);  // Bind value from query string
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
  $article_list = $statement->fetchAll();
  return $article_list;
}

function get_article_list_by_search_term($search_term) {
  $connection = $GLOBALS['connection'];
  $id_present = ( (is_numeric($id)) ? $id : FALSE);
  $query = 'SELECT article.id, article.title, article.media_id, article.published,
      media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype
      FROM article
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.seo_name=:seo_name
      ORDER BY article.published';                 // Query NEEDS UPDATING TO USE SEARCH TERM
  $statement = $connection->prepare($query); 
  $statement->bindValue(':seo_name', $seo_name);  // Bind value from query string
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
  $article_list = $statement->fetchAll();
  return $article_list;
}


// User functions

function get_user_by_id($id) {
	$connection = $GLOBALS['connection'];
	$query = 'SELECT * FROM user WHERE id=:id';             // Query
	$statement = $connection->prepare($query);              // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);      // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); // Object
		$User = $statement->fetch();                        // Fetch
	}
	if ($User) {
		return $User;
	} else {
	    return FALSE;
    }
}

function get_user_list() {
  $connection = $GLOBALS['connection'];
  $query = 'SELECT * FROM user';
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ); 
  $user_list = $statement->fetchAll();        
  return $user_list;
}

function get_user_by_email_passwordhash($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  return (password_verify($password, $user->password) ? $user : false);
}

function create_user_dropdown($selected_id) { 
  $user_list = get_user_list();
  $dropdown = '<select name="user_id" id="user_id" class="form-control" >';
  foreach ($user_list as $user) { 
    $dropdown .= '<option value="' . $user->id . '"';
    if ($selected_id === $user->id) {
      $dropdown .= ' selected';
    }
    $dropdown .= '>' . $user->forename . ' ' . $user->surname . '</option>';
  }
  $dropdown .= '</select>';
  return $dropdown;
}


// Media functions

function get_media_by_id($id) {
  $connection = $GLOBALS['connection'];
    $query = 'SELECT * FROM media WHERE media.id=:id'; // Query
  $statement = $connection->prepare($query);           // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT);   // Bind value from query string
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Media');     // Object
    $Media = $statement->fetch();
  }
  if ($Media) {
    return $Media;
  } else {
    return FALSE;
  }
}

function get_media_list() {
  $connection = $GLOBALS['connection'];       // Connection
  $query = 'SELECT * FROM media';             // Query
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $media_list = $statement->fetchAll();       // Step 4 Get all rows ready to display
  return $media_list;
}

function get_images_list() {  // Does this change to get_all_images_list()
  $query = 'SELECT * FROM media WHERE mediatype LIKE "image%" '; // Query
  $query .= 'ORDER BY id DESC ';                            // Show recent items first
  $statement = $GLOBALS['connection']->prepare($query);     // Prepare
  $statement->execute();                                    // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                 // Object syntax
  $images = $statement->fetchAll();                         // Matches in database
  return $images;                                           // Return as object
}

function get_gallery_list() { 
  $query = 'SELECT * FROM gallery';           // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Gallery');   // Step 4 Set fetch mode to array
  $gallery_list = $statement->fetchAll();     // Step 4 Get all rows ready to display
  return $gallery_list;
}

function get_gallery_by_id($id) {
  $connection = $GLOBALS['connection'];
  $query      = 'SELECT * FROM gallery WHERE gallery.id=:id'; // Query
  $statement  = $connection->prepare($query);           // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT);   // Bind value from query string
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Gallery');     // Object
    $Gallery = $statement->fetch();
  }
  if ($Gallery) {
    return $Gallery;
  } else {
    return FALSE;
  }
}

function insert_gallery_item($media_id, $gallery_id) {
  $sql = 'INSERT INTO galleryitems (media_id, gallery_id)
          VALUES (:media_id, :gallery_id)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':media_id', $media_id, PDO::PARAM_INT);
  $statement->bindParam(':gallery_id', $gallery_id, PDO::PARAM_INT);
  try {
    $statement->execute();
    $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
    $result = FALSE;  // Error
  }
  return $result;                                                   // Say succeeded
}

function delete_gallery_item($media_id, $gallery_id) {
  $connection = $GLOBALS['connection'];                              // Connection
  $sql = 'DELETE FROM galleryitems 
          WHERE media_id=:media_id AND gallery_id=:gallery_id';
  $statement = $connection->prepare($sql);                           // Prepare
  $statement->bindParam(':media_id', $media_id, PDO::PARAM_INT);
  $statement->bindParam(':gallery_id', $gallery_id, PDO::PARAM_INT);
  if($statement->execute()) {                                        // If executes
    return TRUE;                                                     // Say succeeded
  } else {                                                           // Otherwise
    return FALSE;                                                    // Say succeeded
  }   
}

function get_first_image_from_gallery($id) {
  $query = 'SELECT media.*
            FROM galleryitems INNER JOIN media
            ON galleryitems.media_id = media.id
            WHERE galleryitems.gallery_id = :id
            LIMIT 1';           // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->bindValue(':id', $id, PDO::PARAM_INT);   // Bind value from query string
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Media');     // Object
    $Media = $statement->fetch();
  }
  if ($Media) {
    return $Media;
  } else {
    return FALSE;
  }
}


// Login functions

function submit_login($email, $password) { // maybe should return plain error message.
  $connection = $GLOBALS['connection'];
  $user = get_user_by_email_passwordhash($email, $password); 

  if($user) {
    session_start();
    $_SESSION['login']    = $user->id; 
    $_SESSION['forename'] = $user->forename;
    $_SESSION['image']    = ($user->image ? $user->image : 'default.jpg');
    header('Location: index.php');
    exit;
  } 
  return array('status' => 'danger', 'message' =>'Login failed, please try again');
}

function submit_logout() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: index.php');
}


// Helper functions

function format_date($datetime) {
    if (!empty($datetime)) {
	$date = date_create_from_format('Y-m-d H:i:s', $datetime);
 
    return $date->format('F d Y');
    }
    else {
    return "Not published";
    }
}

function clean($text) {
  $text = trim($text);
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', TRUE);
}

function create_slug($title) {
  $title = strtolower($title);
  $title = trim($title);
  return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
}