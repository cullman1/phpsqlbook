<?php
require_once('functions.php'); 

class User {
 public  $id;
 public  $forename;
 public  $surname;
 public  $email;
 public  $password;

 function __construct($id ='', $forename = NULL, $surname = NULL, $email = NULL, $password = NULL) {
    $this->database = Registry::instance()->get('database');   
    $this->connection =  $this->database->connection;   
  $this->id       = ( isset($id)       ? $id       : '');
  $this->forename = ( isset($forename) ? $forename : '');
  $this->surname  = ( isset($surname)  ? $surname  : '');
  $this->email    = ( isset($email)    ? $email    : '');
  $this->password = ( isset($password) ? $password : '');
 }

 function create() {
  $sql = 'INSERT INTO user (forename, surname, email, password) 
          VALUES (:forename, :surname, :email, :password)';           // SQL
  $statement = $this->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':forename', $this->forename);               // Bind value
  $statement->bindValue(':surname', $this->surname);                 // Bind value
  $statement->bindValue(':email', $this->email);                     // Bind value
  $statement->bindValue(':password', $this->password);               // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
   $result = $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
  }
  return $result;                                                   // Say succeeded
 }

 function update() {                           // Connection
  $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email WHERE id = :id';//SQL
   if ($this->image !="") {
      $sql = 'UPDATE user SET forename= :forename, surname = :surname, email= :email, image=:userimg where id= :id';    
  }
  $statement = $this->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':forename', $this->forename);               // Bind value
  $statement->bindValue(':surname', $this->surname);                 // Bind value
  $statement->bindValue(':email', $this->email);                     // Bind value
  if ($this->image !="") {
    $statement->bindValue(':userimg', $this->image);               // Bind value
  }
   $statement->bindValue(':id', $this->id);   
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
   $result = $error->getCode() . ': ' . $error->getMessage(); // Error
  }
  return $result;                                                   // Say succeeded
 }


 function delete() {
                    // Connection
  $sql = 'DELETE FROM user WHERE id = :id';                      // SQL
  $statement = $this->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
  if($statement->execute()) {                                        // If executes
   return TRUE;                                                   // Say succeeded
  } else {                                                           // Otherwise
   return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
  }
 }

  public function getFullName() {
        return $this->forename . ' ' . $this->surname;
    }


}

class Validate {

function numberRange($number, $min = 0, $max = 4294967295) {
  if ( ($number < $min) or ($number > $max) ) {
    return FALSE;
  }
  return TRUE;
}

function stringLength($string, $min = 0, $max = 255) {
  $length = strlen($string);
  if (($length < $min) or ($length > $max)) {
    return FALSE;
  }
  return TRUE;
}

function filename($filename) {
  $error = '';
  if ($this->stringLength($filename, 5, 50) != TRUE) {
    $error = 'Your filename is not long enough.<br>';
  }
  $result = preg_replace('/[^A-z0-9 \.\-\_]/', '', $filename); /// add other characters allowed here
  if ($result != $filename ) {
    $error .= 'You can only use the following characters A-Z, a-z, and numbers 0-9 and . , ! ? &#39; &quot; @ # $ % &amp; * ( ) / \ - .<br>';
  }
  return $error;
}


function isID($id) {
  if ( (!filter_var($id, FILTER_VALIDATE_INT)) or (!$this->numberRange($id, 1, 4294967295)) ) {
        return 'We could not find this item.<br>';
      }
  return '';
}

function isArticleTitle($title) {
  $error = '';
  $title = trim($title);

  if ( ($this->stringLength($title, 3, 255)) == FALSE ) {
    $error = 'Please enter between 3 and 255 characters.<br>';
  }

  $result = preg_replace('/[^A-z0-9 \.,!\?\'\"#\$%&*\(\)\+\-\/]/', '', $title); /// add other characters allowed here
  if ($result != $title ) {
    $error .= 'You can only use the following characters A-Z, a-z, and numbers 0-9 and . , ! ? &#39; &quot; @ # $ % &amp; * ( ) / \ - .<br>';
  }

  return $error;
}

function isArticleContent($article) {
  $error = '';
  if ( ($this->stringLength($article, 1, 30000)) == FALSE ) {
    $error = 'Your article cannot be longer than 30,000 characters.<br>';
    $error .= 'It is currently ' . strlen($article) . ' characters.<br>';
  }
  return $error;
}

function isFirstName($name) {
  $error = '';
  if (($this->stringLength($name, 1, 255)) == FALSE ) {
    $error = 'You cannot have a blank name.<br>';
  }
  return $error;
}

function isLastName($name) {
  return $this->isFirstName($name);
}

function isCategoryName($name) {
  return $this->isArticleTitle($name);
}

function isCategoryTemplate($filename) {
  $error = $this->filename($filename);
  if (! preg_match('/.php$/', $filename) ) {
    $error .= 'Your filename must end with .php';
  }
  return $error;
}

function isMediaTitle($title) {
  return $this->isArticleTitle($title);
}

function isMediaName($name) {
  return $this->isArticleTitle($name);
}

function isMediaAlt($alt) {
  return $this->isArticleTitle($alt);
}

function isMediaFilename($filename) {
  $error = $this->filename($filename);
  if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {
    $error .= 'Your filename must end with .jpg .jpeg .png or .gif';
  }
  return $error;
}

function isMediaUpload($filename) {
  $error ='';
  if (!isset($filename)) {
    $error .= 'Your file did not upload successfully.';
  }
  return $error;
}

function isMimetype($mimetype) {
  if(!preg_match('/(image\/jpg|image\/jpeg|image\/png|image\/gif)/i', $mimetype)) {
    return 'You can only upload jpg, jpeg, png, and gif formats.';
  }
  return '';
}

function isEmail($email) {
  if ( (filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE ) {
    return 'Please enter a valid email address.<br>';
  }
  return '';
}

function isPassword($password) {
  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
  if (isset($error)) {
    return 'Your password cannot be blank.';
  }
  return '';
}

function isStrongPassword($password) {
  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
  if (isset($error)) {
    return 'Your password must contain two uppercase letters, 2 lowercase letters, and a number. It must be between 8 and 32 characters.';
  }
  return '';
}

function isDate($date_array) {
  return (checkdate($date_array[0], $date_array[1], $date_array[2]) ? '' : 'Please enter a valid date');
}

function isDateAndTime($date_time) {
  $date_time_string = $date_time[2] . '-' . $date_time[0] . '-' . $date_time[1] . ' ' . $date_time[3] . ':' . $date_time[4];
  $date_object = date_create($date_time_string);

  if ($date_object == FALSE) {
    return 'Please enter a valid date and time';
  }
  return '';
}
}

class ArticleSummary {
  public  $id;
  public  $title;
  public  $content;
  public  $intro;
  public $published;
  public $categorytemplate;
  public $categoryname; 
  public $articleurl;
  private $category_id;
  private $user_id;
  private $media_id;
  public $comments_count;
  public $comments = array();
  private $validated = FALSE;
  private $connection;

  
  function __construct($id, $title, $intro, $published, $user_id, $categorytemplate, $categoryname) {

    $this->database = Registry::instance()->get('database');   
    $this->connection =  $this->database->connection;    
 $this->id 		= $id;
     $this->title 	= $this->hyphenate_url($title);
      $this->articleurl 	= $this->hyphenate_url($title);
      $this->content = $intro;
      $this->published = $published;
      $this->categorytemplate = $categorytemplate;
       $this->categoryname = $categoryname;
      $this->user_id = $user_id;
  }

  function hyphenate_url($title) {

        $title = str_replace(' ','-', $title);
   
    return $title;
}
   
  function validate($new = FALSE) {}


public function getComments() {
    $query="select comments.*, user.* FROM comments JOIN user ON comments.user_id = user.id  WHERE article_id = :articleid Order by comments.id desc";  
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':articleid',$this->id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $this->comments = $statement->fetchAll();
    return $this->comments;
  }

  public function getCommentHeader() {
  $query= "select uuid() As new_id From article WHERE id = :articleid";
  $statement = $this->connection->prepare($query);
  $statement->bindParam(':articleid',$this->id);
  $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ);
      $header = $statement->fetch();  
      return $header;
  }

  function create() {}

  function update() {}

  function delete() {}
}

class ArticleList {
  public $listName;			// String
  public $articles = array();			// Array holding child objects

  function __construct($listName, $article_list) {
    $this->listName = $listName;
    $count = 0;
    foreach($article_list as $row) {
      $article = new ArticleSummary($row->id,  $row->title,  $row->content, $row->published, $row->user_id,$row->template,$row->name);
      $this->articles[$count] = $article;
      $count++;
    }
  }
}

class Category {
  public $id=0;			// int
  public $name;		// String
  public $template; 		// String
  public $articleSummaryList;	// Array holding array of article summaries
  public $articlesList;		// Array holding array of entire articles
  public $validated = false; 	// Is category validated
  public $connection;
  public $database;

  function __construct($name) { 
    $this->registry =Registry::instance();
    $this->database = $this->registry->get('database');  
    $this->connection =  $this->database->connection;
    $query = "SELECT id, name, template FROM category WHERE name like :name";     // Query
    $statement = $this->connection->prepare($query); // Prepare
    $statement->bindParam(":name", $name);                    // Bind
    $statement->execute();                                // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $category = $statement->fetch(); 
    if($category) {
      $this->id       = $category->id;
      $this->name     = $category->name;
      $this->template = $category->template;
  }
  }

  function create() {}
  
  function update() {}

  function delete(){}

  function validate() {}
  }

  class CategoryList {
  public $categories = array();			// Array holding child objects

  function __construct($category_list) {
    $count = 0;
    foreach($category_list as $row) {
      $category = new Category($row->name);
      $this->categories[$count] = $category;
      $count++;
    }
  }
}


class UrlRewriter {
  public $server;
  public $category = ''; 
  public $item = ''; 

  public function __construct() { $this->parseUrl(0); }

  private function parseUrl($offset) {
    $parts = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),"/");
    $url_parts = explode("/", $parts, $offset+3);
    $this->server = $url_parts[$offset];
    if (isset($url_parts[$offset+1])) {
      $this->category = $url_parts[$offset+1];
    }
    if (isset($url_parts[$offset+2])) {
      $this->item =  $url_parts[$offset+2];
    } 
  }  
} 

class Database{   
  private $serverName = "127.0.0.1";
  private $userName = "root";
  private $password = ""; 
  private $dbName       = "cms";
  public $connection;

  public function __construct() { 
    try {
      $this->connection = new PDO("mysql:host=$this->serverName;dbname=$this->dbName", 
                                  $this->userName, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    } catch (PDOException $error) {
      echo 'Error message: ' . $error->getMessage() . '<br>';
      echo 'File name: ' . $error->getFile() . '<br>';
      echo 'Line number: ' . $error->getLine() . '<br>';
      echo 'Trace number: ' . var_dump($error->getTrace()) . '<br>';
      $date = date("Y-m-d H:i:s"); 
      $text = "\n". $date. " - Line:".$error->getLine()." - " . $error->getTrace() . " : " . 
      $error->getMessage() ." - ". $error->getFile();
      error_log($text, 3, "phpcustom.log");
    }
  }
}
class Registry {
  private $store = array();
  private static $instance = null;
  private function __construct() {}

  public static function instance() {
     if(self::$instance === null) {
        self::$instance = new Registry();
     }
     return self::$instance;
  }

  public function set($key, $value) {
      $this->store[$key] = $value;
  }
  
  public function get($key) {
    if (isset($this->store[$key])) {
      return $this->store[$key];
    }
  }
}

class Layout {
  private $registry;
  private $server;
  private $category;
  private $item;
  private $connection;
  private $single_templates = array();
  private $repeating_templates = array();
  private $error = array('id'=>'', 'title'=>'', 
  'article'=>'','email'=>'', 'password'=>'','date'=>'',
  'firstName'=>'','lastName'=>'', 'image'=>'');
  private $from;
  private $show;
  private $search;

  public function __construct($server, $category, $item) {
    $this->registry = Registry::instance();
    $this->registry->set('database',new Database());
    $this->database = $this->registry->get('database');  
    $this->connection =  $this->database->connection; 
    $this->server = $GLOBALS["website"] = $server;
    $this->category = $category;
    $this->item = $item;
    $this->checkURL();
    $this->createPageStructure();
    $this->assemblePage();
  }

  function getArticles($category = 0, $show, $from, $sort='', $dir='ASC', $search = '', $author_id='0', $name='') {
  //search list
  $list = null;
  if ((!empty($search)) || ($author_id > 0)) {  
   //search results
   $this->articlesCount = count(get_articles_by_search('', '', $sort='', $dir='ASC', 
                                                       $search, $author_id));
   $list = get_articles_by_search($show, $from, $sort='', $dir='ASC', $search, $author_id);
  } else {
   $this->articlesCount = count(get_articles_by_category('', '', $sort='', $dir='ASC',  
                                                         $category, $name));
   $list = get_articles_by_category($show, $from, $sort='', $dir='ASC', $category, $name);
  }
  return $list;
}

public function createPageStructure() { 
  $this->show   = ( isset($_GET['show'])    ? $_GET['show']   : '5' );
  $this->from   =  ( isset($_GET['from'])   ? $_GET['from']   : '0' );
  $this->search =  ( isset($_GET['search']) ? $_GET['search'] : '' );
  switch($this->category) {
  case "Contact":
  case "About":
   $this->single_templates = array("header", "menu", "login", "search","article","footer");
   $this->repeating_templates = array("no_date_content");
   break;
  case "login":
    $this->single_templates = array("header","menu","search","login_form","footer");
    break;
  case "register":
    $this->single_templates = array("header","menu","search","register_form", "footer");
    break;
  case "profile":
    if ($this->item=="view") {
      $this->single_templates = array("header","menu","login", "profile_status", "footer");
    } else {
      $this->single_templates = array("header","menu","login", "profile_update", "footer");
    }             
    break;
  case "search":
  default:
    $this->single_templates = array("header","menu","login","search","article","footer");
   $this->repeating_templates = array("main_content", "author");
    break;     
  }
}

public function checkURL() { 
  switch($this->item) {
        case "logout":
          submit_logout();
          break;     	
  }
}

public function assemblePage() {
  foreach($this->single_templates as $template_section) { 
    if($template_section == "article") {
      $this->assembleArticles($this->repeating_templates);
    } else {
      $this->getHTMLTemplate($template_section);
    }
  }
}

public function getHTMLTemplate($template,$id=""){
  $userId = get_user_from_session(); 
  switch($template) {
   case "author":
   $user = get_user_by_article_id($id);
   $this->mergeData($user, "author_content");
   break;
    case "menu":
      $categorylist = new CategoryList(getCategoryList());
      foreach($categorylist->categories as $category) {
        $this->mergeData($category,"menu_content");
      }
      break;
    default:
      include("/code/chapter_12/templates/".$template.".php");     
      break;
  }
}

public function assembleArticles($templates) {
  //Get the category
  $category = new Category($this->category);
  //Get all articles
  $articlesList = new ArticleList("generic",
   $this->getArticles($category->id, $this->show, 
                   $this->from, '', '' ,$this->search, '', 
                   str_replace('-',' ',$this->item)));
  //If we've got more than zero articles
  if (sizeof($articlesList->articles)!=0) {              
    //Loop through each article id
    for($i=0; $i<sizeof($articlesList->articles); $i++) {
      //Loop through each template
      foreach ($templates as $repeating_template) {     
        //If the template has article data
        if (strpos($repeating_template,"content")) { 
          //Now merge data with the article template
          $this->mergeData($articlesList->articles[$i],  $repeating_template);
        } else {
         //Otherwise, no data,get only HTML template

         $this->getHTMLTemplate($repeating_template, $articlesList->articles[$i]->id);
        }
      }
    }
    //After showing list of articles add paging, if needed
    echo (create_pagination($this->articlesCount, 
          $this->show, $this->from, $this->search));
    } else { 
    //There were zero articles returned by our query.
    echo "</nav><div>No articles found</div>";
  }
}

public function mergeData($data, $file) {
  $html = file_get_contents("code/chapter_12/templates/".$file. ".php"); 
  $html = str_replace("__ROOT" , '/' . $this->server ,
                      $html);  
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $html, $matches);
  echo field_replace($html, $matches[0], $data);             
}

}