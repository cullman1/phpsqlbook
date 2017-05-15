<?php

$serverName   = "mariadb-087.wc1.dfw3.stabletransit.com";
$userName     = "387732_testuser3";
$password     = "phpbo^ok3belonG_3r"; 
$dbName       = "387732_phpbook3";
$GLOBALS['connection'] = new PDO("mysql:".$serverName.";dbname=".$dbName." ", $userName, $password);
$GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
require_once('/cms/includes/functions.php'); 

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
    $this->connection =  $GLOBALS["connection"] ; 
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
    $this->repeating_templates = array("main_content");
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
  $userId = check_user(); 
  switch($template) {
    case "menu":
      $categorylist = new CategoryList(getCategoryList());
      foreach($categorylist->categories as $category) {
        $this->mergeData($category,"menu_content");
      }
      break;
    default:
      include("/cms/templates/".$template.".php");     
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
          $this->mergeData($articlesList->articles[$i], 
                           $repeating_template);
        } else {
         //Otherwise, no data,get only HTML template
         $this->getHTMLTemplate($repeating_template, 
                $articlesList->articles[$i]->id);
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
  $html = file_get_contents("cms/templates/".$file. ".php"); 
  $html = str_replace("__ROOT" , '/' . $this->server ,
                      $html);  
  $regex = '#{{(.*?)}}#';
  preg_match_all($regex, $html, $matches);
  echo field_replace($html, $matches[0], $data);             
}


}



class UrlRewriter {
  public $server;
  public $category = ''; 
  public $item = ''; 

  public function __construct() { 
   $this->parseUrl(0); 
  }

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
    $statement = $GLOBALS["connection"]->prepare($query);
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
      $article = new ArticleSummary($row->{"id"},  $row->{"title"},  $row->{"content"}, $row->{"published"}, $row->{"user_id"},$row->{"template"},$row->{"name"});
      $this->articles[$count] = $article;
      $count++;
    }
  }
}

class CategoryList {
  public $categories = array();			// Array holding child objects

  function __construct($category_list) {
    $count = 0;
    foreach($category_list as $row) {
      $category = new Category($row->{"name"});
      $this->categories[$count] = $category;
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
    $query = "SELECT * FROM category WHERE name like :name";     // Query
    $statement = $GLOBALS["connection"]->prepare($query); // Prepare
    $statement->bindParam(":name", $name);                    // Bind
    $statement->execute();                                // Execute
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $category = $statement->fetch(); 
    if($category) {
      $this->id       = $category->{"id"};
      $this->name     = $category->{"name"};
      $this->template = $category->{"template"};
  }
  }

  function create() {}
  
  function update() {}

  function delete(){}

  function validate() {}
  }

  class User {
  public $id;
  public $forename;
  public $surname;
  public $email;
  public $password;
  public $role_id;
  public $tasks;

  function __construct($id ='', $forename = NULL, $surname = NULL, 
                       $email = NULL, $password = NULL, $role_id = 1) {
    $this->id       = ( isset($id)       ? $id       : '');
    $this->forename = ( isset($forename) ? $forename : '');
    $this->surname  = ( isset($surname)  ? $surname  : '');
    $this->email    = ( isset($email)    ? $email    : '');
    $this->password = ( isset($password) ? $password : '');
    $this->role_id  = $role_id;
  }


  function create() {
    $connection = $GLOBALS['connection'];                             // Connection
    $sql = 'INSERT INTO user (forename, surname, email, password) 
                   VALUES (:forename, :surname, :email, :password)';
    $statement = $connection->prepare($sql);                          // Prepare
    $statement->bindValue(':forename', $this->forename);              // Bind value
    $statement->bindValue(':surname',  $this->surname);               // Bind value
    $statement->bindValue(':email',    $this->email);                 // Bind value
     $hash = password_hash( $this->password, PASSWORD_DEFAULT);
    $statement->bindValue(':password',$hash);
    try {
      $statement->execute();                                          // Try to execute
      $result = TRUE;                                                 // Say worked
    } catch (PDOException $error) {                                   // Otherwise
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];   // Error
    }
    return $result;                                                    
  }

 public function createToken($purpose) {
   $connection = $GLOBALS['connection'];                     // Connect
   $sql = 'SELECT UUID() as token';                          // Tell DB to create UUID
   $statement = $connection->prepare($sql);                  // Prepare 
   $statement->execute();                                    // Execute
   $token = $statement->fetchColumn();                       // Fetch UUID
   $expires = time() + (24 * 60 * 60);                       // Expiry time
   $sql = 'INSERT INTO token (token, user_id, expires, purpose) 
                  VALUES (:token, :user_id, :expires, :purpose)'; // SQL to add token
   $statement = $connection->prepare($sql);                       // Prepare
   $statement->bindValue(':token',   $token);                     // Bind value
   $statement->bindValue(':user_id', $this->id);                  // Bind value
   $statement->bindValue(':expires', $expires);                   // Bind value
   $statement->bindValue(':purpose', $purpose);                   // Bind value
   try {                                                          // Try block
     $statement->execute();                                        // Execute
     $result = $token;                                             // Worked
   } catch (PDOException $error) {                                 // Otherwise
     $result = FALSE;                                              // Error
   }
   return $result;                                                 // Return result
}

}

Class Validate {

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

	function isCategoryName($name) {
	  return $this->isArticleTitle($name);
	}

	function isCategoryDescription($description) {
	  $error = '';
	  if ( ($this->stringLength($description, 1, 1000)) == FALSE ) {
	    $error = 'Your description cannot be longer than 1,000 characters.<br>';
	    $error .= 'It is currently ' . strlen($description) . ' characters.<br>';
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

	function isAllowedExtension($filename) {                        // Check file extension
		$error = '';                                                // Blank error message
		if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {    // If not file extension
			$error .= 'Your filename must end with .jpg .jpeg .png or .gif'; // Error message
		}
		return $error;                                                // Return error
	}

	function isAllowedMediaType($mediatype) {                       // Check media type
		$allowed_mediatypes = Array("image/jpeg", "image/png", "image/gif"); // Allowed 
		if (in_array($mediatype, $allowedmedia_types)) {            // If type is in list
			$error = '';                                            // Blank error message
		} else {                                                    // Otherwise
			$error = 'You can only upload jpg, jpeg, png, and gif formats.'; // Error message
		}
		return $error;                                              // Return error
	}

	function isWithinFileSize($size, $max) {                        // Check file size
		if ($size > $max) {                                         // If size too big
			$error = 'Your file is too large, maximum size is ' . $max; // Error message
		} else {                                                    // Otherwise
			$error = '';                                            // Blank error message
		}
		return $error;                                              // Return error
	}

	function sanitizeFileName($file) {                         // Clean file name
		$file = preg_replace('([\~,;])',       '-', $file);    // Replace \ , ; with -
		$file = preg_replace('([^\w\d\-_~.])',  '', $file);    // Remove unwanted characters
		return $file;                                          // Return cleaned name
	}

	function isGalleryName($name) {
	  return $this->isArticleTitle($name);
	}

	function ismode($mode) {
	  if ( !$this->numberRange($mode, 0, 3) ) {
	        return $mode . ' is not a valid gallery type.<br>';
	      }
	  return '';
	}


	function isName($name) {

	  $error = '';
	  $name = trim($name);

	  if ( ($this->stringLength($name, 1, 255)) == FALSE ) {
	    $error = 'Please enter between 1 and 255 characters.<br>';
	  }

	  $result = preg_replace('/[^A-z\'\-]/', '', $name); /// add other characters allowed here
	  if ($result != $name ) {
	    $error .= 'You can only use the following characters A-Z, a-z, &#39; -<br>';
	  }

	  return $error;
	}

	function isEmail($email) {
	  if ( (filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE ) {
	    return 'Please enter a valid email address.<br>';
	  }
	  return '';
	}

	function isPassword($password) {
	  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
	  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
	  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
	  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
	  if (isset($error)) {
	    return 'Your password must contain 2 uppercase letters, 2 lowercase letters, and a number. It must be between 8 and 32 characters.<br>';
	  }
	  return '';
	}

	function isPasswordLogin($password) {
	  if( (strlen($password)<8) OR (strlen($password)>32) ) { $error = TRUE; }                    // Less than 8 characters
	  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
	  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
	  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
	  if (isset($error)) {
	    return ' ';
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

	function isCategory($Category) {
		$errors = array('id'=>'', 'name'=>'', 'template'=>'');
		if ($Category->id != 'new') {
			$errors['id']   = $this->isID($Category->id);
		}
		$errors['name']        = $this->isCategoryName($Category->name);
		$errors['description'] = $this->isCategoryDescription($Category->description);
		return $errors;
	}


	function isArticle($Article) {
		$errors    = array('title' => '', 'content'=>'', 'published'=>'', 'category_id'=>'', 'user_id'=>'', 'media_id'=>'');          // Form errors
		if ($Article->id != 'new') {
			$errors['id']   = $this->isID($Article->id);
		}
		$errors['title']       = $this->isArticleTitle($Article->title);
		$errors['content']     = $this->isArticleContent($Article->content);
        //		$errors['published']   = $this->isArticleContent($Article->published);
		$errors['category_id'] = $this->isID($Article->category_id);
		$errors['user_id']     = $this->isID($Article->user_id);
		//		$errors['media_id']    = $this->isID($Article->media_id);
		return $errors;
	}


	function isUser($User) {
		$errors    = array('id' => '', 'forename' => '', 'surname'=>'', 'email'=>'', 'password'=>'');    // Form errors
		if ($User->id != 'new') {
			$errors['id']   = $this->isID($User->id);
		}
		$errors['forename'] = $this->isName($User->forename);
		$errors['surname']  = $this->isName($User->surname);
		$errors['email']    = $this->isEmail($User->email);
		$errors['password'] = $this->isPassword($User->password);
		return $errors;
	}

		function isMedia($Media) {                                  // Return cleaned name
		$errors = array('file'=>'', 'title'=>'', 'alt'=>'');   // Errors array
		if ($Media->id != 'new') {                                // If not new media
				$errors['id']   = $this->isID($Media->id);              // Validate id
		}
		$this->filename   = sanitize_file_name($this->filename);          // Clean filenamne
		$errors['title']  = $this->isMediaTitle($Media->title);           // Check title
		$errors['alt']    = $this->isMediaAlt($Media->alt);               // Check alt text
		$errors['file']  .= $this->isAllowedFileExtension($Media->filename); // Check ext
		$errors['file']   = $this->isAllowedMediaType($Media->mediaType); // Check type
		$errors['file']  .= $this->isWithinFileSize($Media->filesize);    // Check size
		return $errors;                                                   // Return array
	}

	function isGallery($Gallery) {
		$errors    = array('name'=>'', 'mode'=>'');          // Form errors
		if ($Gallery->id != 'new') {
			$errors['id']   = $this->isID($Gallery->id);
		}
		$errors['name']        = $this->isGalleryName($Gallery->name);
		$errors['mode'] = $this->ismode($Gallery->mode);
		return $errors;
	}

    function isConfirmPassword($password, $confirm) {
 return ( ($password != $confirm) ? 'Passwords do not match' : '' );
}
}
?>