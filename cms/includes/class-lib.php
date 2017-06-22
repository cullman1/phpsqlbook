<?php

//require_once('includes/functions.php');

class ArticleSummary {
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
  $sql = 'INSERT INTO article (title, seo_title, content, category_id, user_id, media_id, gallery_id) 
          VALUES (:title, :content, :category_id, :user_id, :media_id, :gallery_id)';
  $statement = $connection->prepare($sql);                                   // Prepare
  $statement->bindValue(':title',       $this->title);                       // Bind value
  $statement->bindValue(':seo_title',   create_slug($this->title));          // Bind value
  $statement->bindValue(':content',     $this->content);                     // Bind value
  $statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT); // Bind value
  $statement->bindValue(':user_id',     $this->user_id, PDO::PARAM_INT);     // Bind value
  $statement->bindValue(':media_id',    $this->media_id, PDO::PARAM_INT);    // Bind value
  $statement->bindValue(':gallery_id',  $this->gallery_id, PDO::PARAM_INT);  // Bind value
  try {
   $statement->execute();                                         // Try to execute
   $result = TRUE;                                                // Say worked if it did
  } catch (PDOException $error) {                                    // Otherwise
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
  }
  return $result;                                                    
 }

 function update() {
  $connection = $GLOBALS['connection'];                              // Connection
  $sql = 'UPDATE article SET title = :title, seo_title = :seo_title, content = :content, published = :published, category_id = :category_id, user_id = :user_id, media_id = :media_id, gallery_id = :gallery_id WHERE id = :id';//SQL
  $statement = $connection->prepare($sql);                                   // Prepare
  $statement->bindValue(':id',          $this->id, PDO::PARAM_INT);          // Bind value
  $statement->bindValue(':title',       $this->title);                       // Bind value
  $statement->bindValue(':seo_title',   create_slug($this->title));          // Bind value
  $statement->bindValue(':content',     $this->content);                     // Bind value
  $statement->bindValue(':published',   $this->published);                   // Bind value
  $statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT); // Bind value
  $statement->bindValue(':user_id',     $this->user_id,     PDO::PARAM_INT); // Bind value
  $statement->bindValue(':media_id',    $this->media_id,    PDO::PARAM_INT); // Bind value
  $statement->bindValue(':gallery_id',  $this->gallery_id,  PDO::PARAM_INT); // Bind value
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

class User {
  public $id;
  public $forename;
  public $surname;
  public $email;
  public $password;
    public $image;
  public $role_id;
  public $tasks;

  function __construct($id ='', $forename = NULL, $surname = NULL, 
                       $email = NULL, $password = NULL,  $image='',$role_id = 1) {
    $this->id       = ( isset($id)       ? $id       : '');
    $this->forename = ( isset($forename) ? $forename : '');
    $this->surname  = ( isset($surname)  ? $surname  : '');
    $this->email    = ( isset($email)    ? $email    : '');
    $this->password = ( isset($password) ? $password : '');
     $this->image = ( isset($image) ? $image : '');
    $this->role_id  = $role_id;
  }


  function create() {
    $connection = $GLOBALS['connection'];                             // Connection
    $sql = 'INSERT INTO user (forename, surname, email, password ) 
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

  function update_password($password) {
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = 'UPDATE user SET password = :password WHERE id = :id';
  $statement = $GLOBALS['connection']->prepare($sql);
  $statement->bindParam(':password', $hash);
  $statement->bindParam(':id', $this->id);
  try {
    $statement->execute();
    return TRUE;
  } catch (PDOException $error) {
    return FALSE; 
  }
}

  function createToken($purpose) {
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

  function update() {
   $connection = $GLOBALS['connection'];                              // Connection
  $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email, image = :image WHERE id = :id';//SQL
  $statement = $connection->prepare($sql);                                   // Prepare
  $statement->bindValue(':id',          $this->id, PDO::PARAM_INT);          // Bind value
  $statement->bindValue(':forename',  $this->forename);                       // Bind value
  $statement->bindValue(':surname',   $this->surname);          // Bind value
  $statement->bindValue(':email',     $this->email);                     // Bind value
  $statement->bindValue(':image',   $this->image);                   // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                      // Otherwise
                                                   
          $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
                                                     
  }
  return $result;        
  }
}

class Validate {

	function numberRange($number, $min = 0, $max = 4294967295) {
	  if ( ($number < $min) or ($number > $max) ) {
	    return FALSE;
	  }
		return TRUE;
	}

    function isMediaUpload($filename) {
  $error ='';
  if (!isset($filename)) {
    $error .= 'Your file did not upload successfully.';
  }
  return $error;
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
		$errors    = array('id' => '', 'forename' => '', 'surname'=>'', 'email'=>'', 'image'=>'', 'password'=>'');    // Form errors
		if ($User->id != 'new') {
			$errors['id']   = $this->isID($User->id);
		}
		$errors['forename'] = $this->isName($User->forename);
		$errors['surname']  = $this->isName($User->surname);
		$errors['email']    = $this->isEmail($User->email);
		$errors['image'] = $this->isImage($User->image);
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

function isFirstName($name) {
  $error = '';
  if (($this->stringLength($name, 1, 255)) == FALSE ) {
    $error = 'You cannot have a blank name.<br>';
  }
  return $error;
}

function isImage($image) {
    $error = '';
    if (($this->stringLength($image, 1, 255)) == FALSE ) {
        $error = 'You cannot have a blank image.<br>';
    }
    return $error;
}

function isLastName($name) {
  return $this->isFirstName($name);
}
}

class Comment {
  public $id;
  public $article_id;	// Array holding array of article summaries
  public $user_id;		// String
  public $author; 		// String
  public $comment;
  public $posted;
  public $repliedto_id;
  
  public $nestingLevel;
  public $toplevelparent_id;
  
  function __construct ($id='', $articleid='', $userid=NULL, $author=NULL, $authorimage=NULL, $comment=NULL, $date=NULL, $replyid=0, $toplevelparentid=0, $nestinglevel=0) {
    $this->id = $id;
    $this->article_id   = $articleid;
    $this->user_id      = $userid;
    $this->author      = $author;
    $this->image = ( isset($authorimage)    ? $authorimage    : 'blank.png' ); 
    $this->comment     = $comment;
    $this->posted      = $date;
    $this->repliedto_id   = $replyid;
    $this->toplevelparent_id = $toplevelparentid;
    $this->nestingLevel = $nestinglevel;   
  }

  public function add() {
        try {
  $GLOBALS['connection']->beginTransaction();  
  $query = "INSERT INTO comments (comment, article_id, user_id, posted, repliedto_id, toplevelparent_id) 
              VALUES  (:comment,:articleid, :userid, :date, :replyid, :toplevelparentid)";
    $statement = $GLOBALS["connection"]->prepare($query);
    $statement->bindParam(':comment',$this->comment);
    $statement->bindParam(':articleid',$this->article_id);
    $statement->bindParam(':userid',$this->user_id);
    $date = date("Y-m-d H:i:s");
    $statement->bindParam(':date',$date);
    $statement->bindParam(':replyid',$this->repliedto_id);
    $statement->bindParam(':toplevelparentid',$this->toplevelparent_id);
    $statement->execute();
   $query='UPDATE article SET comment_count = comment_count + 1
        WHERE id = :article_id';
  $statement = $GLOBALS['connection']->prepare($query);   
  $statement->bindValue(':article_id',  $this->article_id);  // Bind value from query string   
  $statement->execute();
  $GLOBALS['connection']->commit();                                       // Commit transaction
  return TRUE;
} catch (PDOException $error) {                                // Failed to update
   echo 'We were not able to update the article ' . $error->getMessage();       
   $GLOBALS['connection']->rollback();                                    // Roll back all SQL
   return FALSE;
}
  } 
  }

class CommentList {
  public $comments = array();// Array holding child objects
  public $commentCount=0;

  function __construct($comment_list) {   
    if (!empty($comment_list)) {
      foreach($comment_list as $comment) {

       // if ($comment->repliedto_id>0) {
      //     $comment->nestinglevel = 1; 
      //  }      
        $this->comments[$this->commentCount] = $comment;
        $this->commentCount++;
      }
    }
  }

  public function add($id, $articleid, $userid, $author, $authorimage, $comment, $posted, $reply='0', $toplevelparentid='0',  $nestinglevel='0') {
    $count = sizeof($this->comments);
    $this->comments[$count] = new Comment($id, $articleid, $userid, $author, $authorimage, $comment, $posted, $reply,  $toplevelparentid, $nestinglevel);
    if ($userid !='') { 
      $this->commentCount++; 
    }
    return $this;
  }
}

?>