<?php
// Create objects
function init_article() {
  $article              = new stdClass();
  $article->id          = (filter_input(INPUT_GET, 'article_id',   FILTER_VALIDATE_INT) ? $_GET['article_id']   : 0); 
  $article->title       = (isset($_POST['title'])   ? $_POST['title']   : '');
  $article->content     = (isset($_POST['content']) ? $_POST['content'] : '');
  $article->published   = (isset($_POST['published']) ? $_POST['published'] : ''); 
  $article->category_id = (filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ? $_POST['category_id'] : 0);
  $article->user_id     = (filter_input(INPUT_POST, 'user_id',     FILTER_VALIDATE_INT) ? $_POST['user_id']     : 0);
  $article->media_id    = (filter_input(INPUT_POST, 'media_id',    FILTER_VALIDATE_INT) ? $_POST['media_id']    : 0);
  return $article;
}
function init_category() {
  $category           = new stdClass();
  $category->id       = (filter_input(INPUT_GET, 'category_id',   FILTER_VALIDATE_INT) ? $_GET['category_id']   : 0); 
  $category->name     = ( isset($_POST['name'])     ?   $_POST['name']         : '' );
  $category->template = ( isset($_POST['template']) ?   $_POST['template']     : '' );
  return $category;
}
function init_user() {
  $user             = new stdClass();
  $user->id         = (filter_input(INPUT_GET, 'user_id',  FILTER_VALIDATE_INT) ? $_GET['user_id']    : 0);
  $user->name       = ( isset($_POST['name'])     ?   $_POST['name']         : '' );
  $user->email      = (filter_input(INPUT_POST, 'email',  FILTER_VALIDATE_EMAIL) ? $_POST['email']    : '');
  $user->password   = ( isset($_POST['password'])     ?   $_POST['password']         : '' );
  $user->picture    = ( isset($_POST['profile'])     ?   $_POST['profile']         : '' );
  return $user;
}
function init_media() {
  $media           = new stdClass();
  $media->id       = (filter_input(INPUT_GET, 'media_id',  FILTER_VALIDATE_INT) ? $_GET['media_id']    : 0);
  $media->title    = ( isset($_POST['title'])    ?   $_POST['title']    : '' );
  $media->alt      = ( isset($_POST['alt'])      ?   $_POST['alt']      : '' );
  $media->type     = ( isset($_POST['type'])     ?   $_POST['type']     : '' );
  $media->filename = ( isset($_POST['filename']) ?   $_POST['filename'] : '' );
  $media->filepath = ( isset($_POST['filepath']) ?   $_POST['filepath'] : '' );
  $media->media_id = ( isset($_POST['media_id']) ?   $_POST['media_id']    : '' );
  return $media;
}
function init_gallery() {
  $gallery              = new stdClass();
  $gallery->id          = (filter_input(INPUT_GET, 'media_id',  FILTER_VALIDATE_INT) ? $_GET['media_id']    : 0);
  $gallery->name        = ( isset($_POST['name']) ? $_POST['name'] : '' );
  $gallery->mode        = ( isset($_POST['mode'])  ? $_POST['mode']  : '' );
  return $gallery;
}

// Get article lists
function get_article_list() { // Return all images as an object
  $query = 'SELECT article.*, file_pith, alt_text, name
            FROM article
            LEFT JOIN media ON article.featured_media_id = media.id
            LEFT JOIN category ON article.category_id = category.id' ;  // Query
  $statement = $GLOBALS['connection']->prepare($query);                 // Prepare
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $article_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $article_list;
}
function get_articles_by_category($id) {
  $query = 'SELECT article.*, media.filepath, media.thumb, media.alt, user.name FROM article
    LEFT JOIN media ON article.media_id = media.id
    LEFT JOIN user ON article.user_id = user.id ';
  if ($id > 0) {
    $query .= 'WHERE article.category_id = :category_id';
  }
  $statement = $GLOBALS['connection']->prepare($query);              // Prepare
  $statement->bindParam(":category_id", $id);               // Bind
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $article_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $article_list;
}
function get_articles_by_user($id) {
  $query = 'SELECT article.*, media.filepath, media.alt, user.name FROM article
    LEFT JOIN media ON article.media_id = media.id
    WHERE user.id = :id';
  $statement = $GLOBALS['connection']->prepare($query);              // Prepare
  $statement->bindParam(":id", $id);               // Bind
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $article_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $article_list;
}
// Get article
function get_article_and_thumb_by_id($id) {  
  $query = 'SELECT article.*, media.filepath, media.alt FROM article
  LEFT JOIN media ON article.media_id = media.id
  WHERE article.id = :id';
  $statement = $GLOBALS['connection']->prepare($query);              // Prepare
  $statement->bindParam(":id", $id);               // Bind
  $statement->execute();                                   // Execute
  $article = $statement->fetch(PDO::FETCH_OBJ);            // Matches in database
  return $article;                                         // Return as object
}
function get_article_user_category_and_thumb_by_id($id) {  
  $query = 'SELECT article.*, media.file_path, media.alt_text, 
       user.forename AS author, user.image,
       category.name FROM article
    LEFT JOIN media ON article.featured_media_id = media.id
    LEFT JOIN user ON article.user_id = user.id
    LEFT JOIN category ON article.category_id = category.id
    WHERE article.id = :id';
   $statement = $GLOBALS['connection']->prepare($query);     // Prepare
    $statement->bindParam(":id", $id);                       // Bind
    $statement->execute();                                   // Execute
    $article = $statement->fetch(PDO::FETCH_OBJ);            // Matches in database
    return $article;                                         // Return as object
}

// Get media list
function get_images_list() { 
  $query = 'SELECT * FROM media WHERE type LIKE "image%"'; // Query
  $query .= "ORDER BY id DESC ";                           // Query
  $statement = $GLOBALS['connection']->prepare($query);               // Prepare
  $statement->execute();                                   // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                // Object syntax
  $images = $statement->fetchAll();                        // Matches in database
  return $images;                                          // Return as object
}
// Get media list
function get_media_list($orderby = 'id', $direction = 'ASC') { 
  switch ($orderby) {
    case 'title':
      $orderby = 'title';
      break;
    case 'filename':
      $orderby = 'filename';
      break;
    case 'type':
      $orderby = 'type';
      break;
    default:
      $orderby = 'id';
      break;
  }
  switch ($direction) {
    case 'ASC':
      $direction = ' ASC';
      break;
    default:
      $direction = ' DESC';
      break;
  }
  $query = 'SELECT * FROM media ';                         // Query
  $query .= 'ORDER BY ' . $orderby . $direction;             // Query
  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
  $statement->execute();                                   // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                // Object syntax
  $media = $statement->fetchAll();                         // Matches in database
  return $media;                                           // Return as object
}
// Get individual media
function get_media_by_id($id) {
  $query = 'SELECT * FROM media WHERE id = :media_id'; // Query
  $statement = $GLOBALS['connection']->prepare($query);           // Prepare
  $statement->bindParam(":media_id", $id);             // Bind
  $statement->execute();                               // Execute
  $media = $statement->fetch(PDO::FETCH_OBJ);          // Get data
  return $media;
}

// Get media list
function get_gallery_list() { 
  $query = 'SELECT * FROM gallery'; // Query
  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
  $statement->execute();                                   // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                // Object syntax
  $gallery_list = $statement->fetchAll();                  // Matches in database
  return $gallery_list;                                    // Return as object
}
// THIS SHOULD PROBABLY GET THE ARRAY AT THE SAME TIME
function get_gallery_by_id($id) {
  $query = 'SELECT * FROM gallery WHERE id = :gallery_id'; // Query
  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
  $statement->bindParam(":gallery_id", $id);               // Bind
  $statement->execute();                                   // Execute
  $gallery = $statement->fetch(PDO::FETCH_OBJ);            // Get data
  return $gallery;
}

function get_gallery_content($id) {
  $query = 'SELECT gallery_id, media_id, priority FROM galleryitems WHERE gallery_id = :gallery_id ORDER BY priority'; // Query
  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
  $statement->bindParam(":gallery_id", $id);               // Bind
  $statement->execute();                                   // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);     // Step 4 Set fetch mode to array
  $galleryitems = $statement->fetchAll();            // Get data
  return $galleryitems;  
}


// Get categories
function get_category_list() {
  $query = 'SELECT * FROM category'; // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);     // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}
function get_category_list_array() {
  $query = 'SELECT id, name FROM category'; // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_ASSOC);   // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}
// Get category
function get_category_by_id($id) {
  global $connection;
  $query = 'SELECT * FROM category WHERE id = :id';     // Query
  $statement = $GLOBALS['connection']->prepare($query); // Prepare
  $statement->bindParam(":id", $id);                    // Bind
  $statement->execute();                                // Execute
  $category = $statement->fetch(PDO::FETCH_OBJ);        // Fetch as object
  return $category;                                     // Return object
}

// Get users
function get_user_list() {
  $query = 'SELECT * FROM user';                // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $user_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $user_list;
}
function get_user_list_array() {
  $query = 'SELECT * FROM user';                // Query
  $statement = $GLOBALS['connection']->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_ASSOC);   // Step 4 Set fetch mode to array
  $user_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $user_list;
}
// Get user
function get_user_by_id($id) {
  $query = 'SELECT * FROM user WHERE id = :id'; // Query
  $statement = $GLOBALS['connection']->prepare($query);              // Prepare
  $statement->bindParam(":id", $id);                 // Bind
  $statement->execute();                                  // Execute
  $user = $statement->fetch(PDO::FETCH_OBJ);                         // Get data
  return $user;
}

// Insert
function insert_article($title, $content, $category_id, $user_id, $media_id){
  $sql = 'INSERT INTO article (title, content, category_id, user_id, media_id)
          VALUES (:title, :content, :category_id, :user_id, :media_id)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':title', $title);
  $statement->bindParam(':content', $content);
  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id',     $user_id, PDO::PARAM_INT);
  $statement->bindParam(':media_id',    $media_id, PDO::PARAM_INT);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Article created</div>';
  }
}
function insert_category($name, $template) {
  $sql = 'INSERT INTO category (name, template)
          VALUES (:name, :template)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':name', $name);
  $statement->bindParam(':template', $template);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Category created</div>';
  }
}
function insert_user($name, $email, $password, $picture) {
  $sql = 'INSERT INTO user (name, email, password, picture)
          VALUES (:name, :email, :password, :picture)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':name', $name);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':password', $password);
  $statement->bindParam(':picture', $picture);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">User created</div>';
  }
}
function insert_gallery($name, $mode) {
  $sql = 'INSERT INTO gallery (name, mode)
          VALUES (:name, :mode)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':name', $name);
  $statement->bindParam(':mode', $mode);
  $statement->execute();
  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Gallery created</div>';
  }
}

function insert_gallery_item($media_id, $gallery_id, $checked) {
  $sql = 'INSERT INTO galleryitems (media_id, gallery_id)
          VALUES (:media_id, :gallery_id)';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':media_id', $media_id);
  $statement->bindParam(':gallery_id', $gallery_id);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return true;
  } else {
    return false;
  }
}

// Media upload
function resize_image($path, $new_width, $new_height) {
  $file_type = exif_imagetype($path);                          // Get image type 
  list($current_width, $current_height) = getimagesize($path); // Get height and width of image 
  $ratio = $current_width / $current_height;                   // Get aspect ratio
  if ($new_width / $new_height > $ratio) {                     // If a portrait picture
    $new_width = $new_height * $ratio;                         // Set new width
  } else {                                                     // Otherwise is landscape / square
    $new_height = $new_width / $ratio;                         // Set new height
  }
  switch($file_type) {
    case 1:
      $thumbpath     = substr($path,0,-4)."_thumbnail.gif";           // Thumbnail path
      $current_image = imagecreatefromgif($path);                     // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagegif($new_image, $thumbpath);                               // Save image
      return $thumbpath;
    case 2:
      if (strtolower(substr($path,-4)) == '.jpg' ){                   // .jpg extension
        $thumbpath   = substr($path,0,-4)."_thumbnail.jpg";           // Thumbnail path
      } else {                                                        // Else .jpeg
        $thumbpath   = substr($path,0,-4)."_thumbnail.jpeg";          // Thumbnail path
      }
      $current_image = imagecreatefromjpeg($path);                    // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagejpeg($new_image, $thumbpath);                               // Save image
      return $thumbpath;
    case 3:
      $thumbpath     = substr($path,0,-4)."_thumbnail.png";           // Thumbnail path
      $current_image = imagecreatefrompng($path);                     // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagepng($new_image, $thumbpath);                               // Save image
      return $thumbpath;
  }
  return '';
}
function upload_file($file, $title, $alt) {
  $date      = date("Y-m-d H:i:s");       // Today's date
  $type      = $file['type'];             // Type of file from $_FILES superglobal
  $temporary = $file['tmp_name'];         // Temp file location $_FILES superglobal
  $filename  = $file['name'];             // Name of file from $_FILES superglobal
  $filemove  = '../uploads/' . $filename; // Filepath = relative directory + filename
  $filepath  = 'uploads/' . $filename;    // Filepath = relative directory + filename
  $thumb     = '';                        // See resize-image.php, it returns the path
  if (file_exists($filemove)) {
    return '<div class="error">Image already exists</div>';
  }
  if(move_uploaded_file($temporary, $filemove)) {

    $thumb = resize_image($filemove, 150, 150);

    $sql = "INSERT INTO media(title, alt, date, type, filename, filepath, thumb) 
    VALUES (:title,:alt,:date,:type,:filename,:filepath,:thumb)";
    $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
    $statement->bindParam(":title",    $title);
    $statement->bindParam(":alt",      $alt);
    $statement->bindParam(":date",     $date);
    $statement->bindParam(":type",     $type);
    $statement->bindParam(":filename", $filename);
    $statement->bindParam(":filepath", $filepath);
    $statement->bindParam(":thumb",    $thumb);
    $statement->execute();
    if($statement->errorCode()==0) {
      return '<div class="success">' . $filename . ' uploaded successfully. </div>';
    } else {
      return '<div class="error">Information about your file could not be saved.</div>';
    }
  } else { 
    return '<div class="error">Your image could not be saved.</div>';
  }
}

// Update
function update_article($id, $title, $content, $category_id, $user_id, $media_id) {
  $sql = 'UPDATE article 
        SET title = :title,
            content = :content,
            category_id = :category_id,
            user_id = :user_id,
            media_id = :media_id
        WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':id',          $id, PDO::PARAM_INT);
  $statement->bindParam(':title',       $title);
  $statement->bindParam(':content',     $content);
  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
  $statement->bindParam(':user_id',     $user_id, PDO::PARAM_INT);
  $statement->bindParam(':media_id',    $media_id, PDO::PARAM_INT);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Article updated</div>';
  }
}
function update_category($id, $name, $template) {
  $sql = 'UPDATE category 
        SET name = :name,
            template = :template
          WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':name', $name);
  $statement->bindParam(':template', $template);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Category updated</div>';
  }
}
function update_user($id, $name, $email, $password, $picture) {
  $sql = 'UPDATE user 
        SET name = :name,
            email = :email,
            password = :password,
            picture = :picture
          WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':name', $name);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':password', $password);
  $statement->bindParam(':picture', $picture);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">User updated</div>';
  }
}
function update_media($id, $title, $alt) {
  $sql = 'UPDATE media 
          SET title = :title, alt = :alt
          WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':title', $title);
  $statement->bindParam(':alt', $alt);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Media updated</div>';
  }
}
function update_gallery($id, $name, $mode) {
  $sql = 'UPDATE gallery 
          SET name = :name, mode = :mode
          WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':id', $id);
  $statement->bindParam(':name', $name);
  $statement->bindParam(':mode', $mode);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Media updated</div>';
  }
}

// Delete
function delete_category($id) {
  $sql = 'DELETE FROM category
          WHERE id = :id'; // SQL
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindValue(':id', $id);
  $statement->execute();
  if($statement->errorCode()!=00000) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Category deleted</div>';
  }
}
function delete_user($id) {
  $sql = 'DELETE FROM user
          WHERE id = :id'; // SQL
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindValue(':id', $id);
  $statement->execute();
  if($statement->errorCode()!=00000) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">User deleted</div>';
  }
}
function delete_article($id) {
  $sql = 'DELETE FROM article
          WHERE id = :id'; // SQL
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindValue(':id', $id);
  $statement->execute();
  if($statement->errorCode()!=00000) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Article deleted</div>';
  }
}
function delete_media($id) {
  $query = 'SELECT filepath, thumb FROM media
          WHERE id = :id'; // SQL
  $statement = $GLOBALS['connection']->prepare($query);              // Prepare
  $statement->bindValue(':id', $id);
  $statement->execute();
  $row = $statement->fetch();
  $deleted = unlink('../' . $row['filepath']);
  $deleted = unlink($row['thumb']);

  $sql = 'DELETE FROM media
          WHERE id = :id'; // SQL
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindValue(':id', $id);
  $statement->execute();
  if($statement->errorCode()!=00000) {     
    return '<div class="error">Error: ' . $statement->errorCode() . '</div>';
  } else {
    return '<div class="success">Media deleted</div>';
  }
}
function delete_gallery_item($media_id, $gallery_id, $checked) {
  $sql = 'DELETE FROM galleryitems
          WHERE media_id = :media_id AND gallery_id = :gallery_id';
  $statement = $GLOBALS['connection']->prepare($sql);              // Prepare
  $statement->bindParam(':media_id', $media_id);
  $statement->bindParam(':gallery_id', $gallery_id);
  $statement->execute();

  if( $statement->errorCode() != 00000 ) {     
    return true;
  } else {
    return false;
  }
}

// Related articles
function get_related_articles($category_id=0, $article_id=0) {
  $query = 'SELECT article.*, media.filepath, media.thumb, media.alt FROM article
    LEFT JOIN media ON article.media_id = media.id ';
  if ($category_id > 0) {
    $query .= 'WHERE (article.category_id = :category_id) ';
  }
  if ($article_id > 0) {
//    $query .= 'AND (id != :article_id) ';
  }
  $query .= ' LIMIT 3';
  $statement = $GLOBALS['connection']->prepare($query); 
  if ($category_id > 0) {
    $statement->bindParam(":category_id", $category_id, PDO::PARAM_INT);   // Bind
  }
  if ($article_id > 0) {
//    $statement->bindParam(":article_id", $article_id, PDO::PARAM_INT);     // Bind
  }
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $article_list = $statement->fetchAll();     // Step 4 Get all rows ready to display
  return $article_list;
}

// Selectboxes
function get_category_selectbox($id) {
  $category_list = get_category_list_array(); 
  $selectbox = '<select name="category_id" class="form-control">';
  foreach ($category_list as $category) {
    $selectbox .= '  <option value="' . $category['id'] . '"';
    if ($category['id'] == $id) {
      $selectbox .= ' selected ';
    }
    $selectbox .= '>' . $category['name'] . '</option>';
  }
  $selectbox .= '</select>';
  return $selectbox;
}
function get_author_selectbox($id) {
  $author_list = get_user_list_array(); 
  $selectbox = '<select name="user_id" class="form-control">';
  foreach ($author_list as $author) {
    $selectbox .= '  <option value="' . $author['id'] . '"';
    if ($author['id'] == $id) {
      $selectbox .= ' selected ';
    }
    $selectbox .= '>' . $author['forename'] . '</option>';
  }
  $selectbox .= '</select>';
  return $selectbox;
}

// Format date
function convert_date($date) {
  $date_object = new DateTime($date); // Create DateTime object
  $date_string = $date_object->format('d M Y (H:m:s a)'); // Format the DateTime object as string
  return $date_string;               // Return formatted string
}

function get_general_mime_type($filetype){
  $media_array = explode('/', $filetype);
  $filetype = $media_array[0];
  return $filetype;
}
function display_media($media){
  $filetype = get_general_mime_type($media->type);
  switch ($filetype) {
    case 'image':
      $displayHTML = '<img src="' . $media->thumb . '" alt="' . $media->alt . '">';
      break;
    case 'audio':
      $displayHTML = '<audio controls><source src="' . $media->filepath . '" alt="' . $media->type . '"></audio>';
      break;
    case 'video':
      $displayHTML = '<video controls><source src="' . $media->filepath . '" alt="' . $media->type . '"></video>'; // size
      break;
    default:
      $displayHTML = '<a href="' . $media->filepath . '">' . $media->name . '</a>';
      break;
  }
  return $displayHTML;
}

?>