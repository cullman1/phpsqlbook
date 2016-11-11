<?php 
class Database{   
  private $serverName = "127.0.0.1";
  private $userName = "root";
  private $password = ""; 
  private $databaseName = "cms";
  private $dbName       = "cms";
  private $connection;

  public function __construct() { 
    try {
      $this->connection = new PDO("mysql:host=$this->serverName;dbname=$this->dbName", $this->userName, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      $this->connection->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true); 
    } catch (PDOException $error) {
      echo 'Error message: ' . $error->getMessage() . '<br>';
      echo 'File name: ' . $error->getFile() . '<br>';
      echo 'Line number: ' . $error->getLine() . '<br>';
      echo 'Trace number: ' . var_dump($error->getTrace()) . '<br>';
    }
  }

function add_user($forename, $surname, $password, $email) {     
  $query = 'INSERT INTO user (forename, surname, email, password) 
            VALUES (:forename, :surname, :email, :password)';
  $statement = $this->connection->prepare($query);
  $statement->bindParam(':forename', $forename );
  $statement->bindParam(':surname', $surname );
  $statement->bindParam(':email',$email);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $statement->bindParam(':password',$hash);
  $result = $statement->execute();
  if( $result == true ) {     
      return true;
  } else {
      return $statement->errorCode();
  }  
 }

function get_user_by_email_passwordhash($email, $password) {
  $query = 'SELECT user.* FROM user WHERE email = :email';
  $statement = $this->connection->prepare($query);
  $statement->bindParam(':email',$email);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  if (!$user) { return false; }
  return (password_verify($password, $user->{'user.password'}) ? $user : false);
} 

  public function get_article_by_id($id, $search='') {
    $query = "select article.*, category.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :id";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll(); 
    if (isset($search)) {
      foreach($article_list as $article) {
        $article->{'article.content'} = str_ireplace($search, "<b style='background-color:yellow'>".$search."</b>", $article->{'article.content'}); 
      }
    }
    return $article_list; 
  }

  public function get_article_list($category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
    $query= "select article.*, category.* FROM article JOIN user ON user.id = article.user_id JOIN category ON category.id= article.category_id where published <= now()";
    
    if (!empty($search)) {  //search results
      $search = trim($search);
      $searchsql = " AND ((title like '%" .$search. "%')";
      $searchsql .= " OR (content like '%".$search. "%'))";
      $query .= $searchsql;   
    }
  
    //category list
    if (($category > 0) && (!empty($name))) {
      $query .= ' AND  title=:id';
    } else if ($category > 0) {
      $query .= ' AND article.category_id = :id';
    }
    
    //author list
    if ($author_id > 0) {
      $query .= ' AND user.id = :id';
    }

    //Sort
    if (!empty($sort)) {
      $query .= " Order By " . $show . " " . $dir;
    }

    //Get total number of articles for count
    $articles_for_count = $this->bind_parameters($query, $category, $name, $author_id);          
    $num_rows = count($articles_for_count);
    
    //Get actual limited page of articles
    $query .= " limit " . $show . " offset " . $from;
    $article_list = $this->bind_parameters($query, $category, $name, $author_id);        
    return $this->append_row_count($article_list,$num_rows);
}

public function bind_parameters($query, $category, $name, $author_id) {
 $statement = $this->connection->prepare($query);
    if (($category > 0) && (!empty($name))) {
     $statement->bindParam(":id", $name); 
    }  else if ($category > 0) {
     $statement->bindParam(":id", $category);    
    }
    if ($author_id > 0) {
        $statement->bindParam(":id", $author_id);    
    }
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $article_list = $statement->fetchAll();  
    return $article_list;
}

public function append_row_count($article_list, $num_rows) {
    foreach ($article_list as $article) {
     $article->{"article.row_count"} = $num_rows;
     }
    return $article_list;
}

public function get_author_name($id) { 
  $query = "select article.*, user.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :article_id";
 $statement = $this->connection->prepare($query);
 $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_OBJ);
 $author_list = $statement->fetchAll();  
 return $author_list;
}
  
public function get_all_likes($user_id,$article_id) {
  $query = "select distinct :artid as articleid, :userid as userid, (select count(*) as likes FROM article_like where article_id=:artid and user_id=:userid ) as likes_count, (select count(article_id) as likes FROM article_like where article_id=:artid) as likes_total FROM article_like as a right outer join (select id FROM article where id=:artid) as b ON (b.id = a.article_id) where b.id=:artid"; 
  $statement = $this->connection->prepare($query);
  $statement->bindParam(':artid', $article_id);
  $statement->bindParam(':userid',$user_id);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);  
  $author_list = $statement->fetchAll();  
   return $author_list;
}

public function getProfile($user_id) {
$query = "select user.* FROM user where user.id=:userid";
 $statement = $this->connection->prepare($query);
 $statement->bindParam(':userid',$user_id);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_OBJ);
  $author_list = $statement->fetchAll();  
   return $author_list;
}

public function get_user_by_email($email) {
  $query = "SELECT * from user WHERE email = :email";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':email',$email);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $author_list = $statement->fetchAll();
   return $author_list;
}

public function setProfile( $id, $forename, $surname, $email, $img) {
  $query = 'UPDATE user SET forename= :forename, surname = :surname, email= :email where user.id= :userid';
  if ($img!="") {
      $query = 'UPDATE user SET forename= :forename, surname = :surname, email= :email, image=:userimg where user.id= :userid';
      
  }
  $statement = $this->connection->prepare($query);
  if ($img!="") {
      $statement->bindParam(':userimg',$img);
      
  }
  
  $statement->bindParam(':userid',$id);
  $statement->bindParam(':forename',$forename);
  $statement->bindParam(':surname',$surname);
  $statement->bindParam(':email',$email);

  $statement->execute();
  if( $statement->errorCode() != 00000 ) {     
        return array('status' => 'danger', 'message' =>'Profile update failed, Please try again');
  } else {
      return array('status' => 'success', 'message' =>'Profile updated');
  }
}

function getLogin( $email, $passwordToken) {
    $query = "SELECT user.id, forename, surname, email from user WHERE email = :email AND password= :password AND active= 0";
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password',$passwordToken);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $user = $statement->fetchAll();  
    return $user;
}

function setLike($likes, $userid, $articleid) {
  if($likes=="0") {
      $query = "INSERT INTO article_like (user_id, article_id) VALUES (:userid, :articleid)";
    } else {
      $query = "DELETE FROM article_like WHERE user_id= :userid and article_id= :articleid";
    }
    $statement = $this->connection->prepare($query);
    $statement->bindParam(":userid", $userid);
    $statement->bindParam(":articleid", $articleid);
    $statement->execute();
 }
 //From function.php
 // Get article lists
function get_article_list2() { // Return all images as an object
  $query = 'SELECT article.*, media.filepath, media.alt, category.name
            FROM article
            LEFT JOIN media ON article.media_id = media.id
            LEFT JOIN category ON article.category_id = category.id' ;  // Query
  $statement = $this->connection->prepare($query);                 // Prepare
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
  $statement = $this->connection->prepare($query);              // Prepare
  $statement->bindParam(":id", $id);               // Bind
  $statement->execute();                                   // Execute
  $article = $statement->fetch(PDO::FETCH_OBJ);            // Matches in database
  return $article;                                         // Return as object
}
function get_article_user_category_and_thumb_by_id($id) {  
  $query = 'SELECT article.*, media.filepath, media.alt, 
       user.name AS author, user.picture,
       category.name FROM article
    LEFT JOIN media ON article.media_id = media.id
    LEFT JOIN user ON article.user_id = user.id
    LEFT JOIN category ON article.category_id = category.id
    WHERE article.id = :id';
   $statement = $this->connection->prepare($query);     // Prepare
    $statement->bindParam(":id", $id);                       // Bind
    $statement->execute();                                   // Execute
    $article = $statement->fetch(PDO::FETCH_OBJ);            // Matches in database
    return $article;                                         // Return as object
}

// Get media list
function get_images_list() { 
  $query = 'SELECT * FROM media WHERE type LIKE "image%"'; // Query
  $query .= "ORDER BY id DESC ";                           // Query
  $statement = $this->connection->prepare($query);               // Prepare
  $statement->execute();                                   // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                // Object syntax
  $images = $statement->fetchAll();                        // Matches in database
  return $images;                                          // Return as object
}
// Get media
function get_media_by_id($id) {
  $query = 'SELECT * FROM media WHERE id = :media_id'; // Query
  $statement = $this->connection->prepare($query);           // Prepare
  $statement->bindParam(":media_id", $id);             // Bind
  $statement->execute();                               // Execute
  $media = $statement->fetch(PDO::FETCH_OBJ);          // Get data
  return $media;
}

// Get categories
function get_category_list() {
  $query = 'SELECT * FROM category'; // Query
  $statement = $this->connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);     // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}
function get_category_list_array() {
  $query = 'SELECT id, name, template FROM category'; // Query
  $statement = $this->connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_ASSOC);   // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display
  return $category_list;
}
// Get category
function get_category_by_id($id) {
  global $connection;
  $query = 'SELECT * FROM category WHERE id = :id';     // Query
  $statement = $this->connection->prepare($query); // Prepare
  $statement->bindParam(":id", $id);                    // Bind
  $statement->execute();                                // Execute
  $category = $statement->fetch(PDO::FETCH_OBJ);        // Fetch as object
  return $category;                                     // Return object
}

// Get category
function get_category_by_name($name) {
  $query = "SELECT coalesce(id, count(category.id)) as count_id, id, name, template FROM category WHERE name like :name";     // Query
  $statement = $this->connection->prepare($query); // Prepare
  $statement->bindParam(":name", $name);                    // Bind
  $statement->execute();                                // Execute
  $category = $statement->fetch(PDO::FETCH_OBJ);        // Fetch as object
  return $category;                                     // Return object
}
// Get users
function get_user_list() {
  $query = 'SELECT * FROM user';                // Query
  $statement = $this->connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $user_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $user_list;
}
function get_user_list_array() {
  $query = 'SELECT * FROM user';                // Query
  $statement = $this->connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_ASSOC);   // Step 4 Set fetch mode to array
  $user_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $user_list;
}
// Get user
function get_user_by_id($id) {
  $query = 'SELECT * FROM user WHERE id = :id'; // Query
  $statement =$this->connection->prepare($query);              // Prepare
  $statement->bindParam(":id", $id);                 // Bind
  $statement->execute();                                  // Execute
  $user = $statement->fetch(PDO::FETCH_OBJ);                         // Get data
  return $user;
}

// Insert
function insert_article($title, $content, $category_id, $user_id, $media_id){
  $sql = 'INSERT INTO article (title, content, category_id, user_id, media_id)
          VALUES (:title, :content, :category_id, :user_id, :media_id)';
  $statement = $this->connection->prepare($sql);              // Prepare
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
  $statement = $this->connection->prepare($sql);              // Prepare
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
  $statement = $this->connection->prepare($sql);              // Prepare
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
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->bindParam(':title', $title);
  $statement->bindParam(':content', $content);
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

  public function submit_register() {
    $error='';
    if (!empty($_POST['password']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['emailAddress']) ) {
      if (!preg_match("#.*^(?=.{8,50})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['password'])){
        $error='password-not-strong-enough';
      } else {
        $query = "SELECT * from user WHERE email = :email";
        $email = $_POST['emailAddress'];
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':email',$email);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $statement->fetchAll();
        $num_rows = count($rows);
        if($num_rows>0) {
          $error='user-exists'; /* User exists */
        }    else   {   
          $statement2 = $this->add_user($_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['emailAddress']);
          if($statement2===true) {  
            $error='insert-succeeded';
          } else {
            $error='insert-failed'; 
          }
        }
      }
      header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/register/'.$error);
    }
  }
}
?>