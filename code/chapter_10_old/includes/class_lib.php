<?php
class User {
  public $id;
  public $forename;
  public $surname;
  public $email;
  public $password;

  function __construct($id ='', $forename = NULL, $surname = NULL, 
                       $email = NULL, $password = NULL) {
    $this->id       = ( isset($id)       ? $id       : '');
    $this->forename = ( isset($forname)  ? $forename : '');
    $this->surname  = ( isset($surname)  ? $surname  : '');
    $this->email    = ( isset($email)    ? $email    : '');
    $this->password = ( isset($password) ? $password : '');
  }

  function create() {
    $connection = $GLOBALS['connection'];                             // Connection
    $sql = 'INSERT INTO user (forename, surname, email, password) 
                   VALUES (:forename, :surname, :email, :password)';
    $statement = $connection->prepare($sql);                          // Prepare
    $statement->bindValue(':forename', $this->forename);              // Bind value
    $statement->bindValue(':surname',  $this->surname);               // Bind value
    $statement->bindValue(':email',    $this->email);                 // Bind value
    $statement->bindValue(':password', $this->password);              // Bind value
    try {
      $statement->execute();                                          // Try to execute
      $result = TRUE;                                                 // Say worked
    } catch (PDOException $error) {                                   // Otherwise
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];   // Error
    }
    return $result;                                                    
  }

  function update() {
    $connection = $GLOBALS['connection'];                             // Connection
    $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email,
                            password = :password WHERE id = :id';
    // NOTE: The rest of the update() method is the same as steps 5-10 above.
     $statement = $connection->prepare($sql);                          // Prepare
    $statement->bindValue(':forename', $this->forename);              // Bind value
    $statement->bindValue(':surname',  $this->surname);               // Bind value
    $statement->bindValue(':email',    $this->email);                 // Bind value
    $statement->bindValue(':password', $this->password);              // Bind value
    try {
      $statement->execute();                                          // Try to execute
      $result = TRUE;                                                 // Say worked
    } catch (PDOException $error) {                                   // Otherwise
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];   // Error
    }
    return $result;             
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
  if( $password != $confirm)  { $error = TRUE; }                    
  if (isset($error)) {
    return 'Your password must match your confirm password.';
  }
  return '';
}
}
?>