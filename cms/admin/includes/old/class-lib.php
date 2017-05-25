<?php

Class Article {
	public  $id;
	public  $title;
	public  $content;
	public  $published;
	public  $category_id;
	public  $user_id;
	public  $media_id;
	public  $validated = FALSE;

	function __construct($id ='', $title = NULL, $content = NULL, $published = NULL, $category_id = NULL, $user_id = NULL, $media_id = NULL) {
		$this->id          = ( isset($id)          ? $id          : '');
		$this->title       = ( isset($title)       ? $title       : '');
		$this->content     = ( isset($content)     ? $content     : '');
		$this->published   = ( isset($published)   ? $published   : '');
		$this->category_id = ( isset($category_id) ? $category_id : '');
		$this->user_id     = ( isset($user_id)     ? $user_id     : '');
		$this->media_id    = ( isset($media_id)    ? $media_id    : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO article (title, content, published, category_id, user_id, media_id) 
		        VALUES (:title, :content, :published, :category_id, :user_id, :media_id)';
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':title',       $this->title);               // Bind value
		$statement->bindValue(':content',     $this->content);             // Bind value
		$statement->bindValue(':published',   $this->published);           // Bind value
		$statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);         // Bind value
		$statement->bindValue(':user_id',     $this->user_id, PDO::PARAM_INT);             // Bind value
		$statement->bindValue(':media_id',    $this->media_id, PDO::PARAM_INT);            // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
			$result = $error->getCode() . ': ' . $error->getMessage(); // Error
		}
		return $result;                                                   // Say succeeded
	}

	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE article SET title = :title, content = :content, published = :published, category_id = :category_id, user_id = :user_id, media_id = :media_id WHERE id = :id';//SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id',          $this->id, PDO::PARAM_INT);                  // Bind value
		$statement->bindValue(':title',       $this->title);               // Bind value
		$statement->bindValue(':content',     $this->content);             // Bind value
		$statement->bindValue(':published',   $this->published);           // Bind value
		$statement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);         // Bind value
		$statement->bindValue(':user_id',     $this->user_id, PDO::PARAM_INT);             // Bind value
		$statement->bindValue(':media_id',    $this->media_id, PDO::PARAM_INT);            // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
			$result = $error->getCode() . ': ' . $error->getMessage(); // Error
		}
		return $result;                                                   // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM article WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		if($statement->execute()) {                                        // If executes
			return TRUE;                                                   // Say succeeded
		} else {                                                           // Otherwise
			return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
		}
	}
}

Class Category {
	public  $id;
	public  $name;
	public  $description;

	function __construct($id ='', $name = NULL, $description = NULL) {
		$this->id          = ( isset($id)          ? $id       : '');
		$this->name        = ( isset($name)        ? $name     : '');
		$this->description = ( isset($description) ? $description : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO category (name, description) VALUES (:name, :description)'; // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':name', $this->name);                       // Bind name
		$statement->bindValue(':description', $this->description);         // Bind description
		/* duplicate error code 
			if($statement->execute()) {                                        // If executes
				return TRUE;                                                   // Say succeeded
			} else {                                                           // Otherwise
				return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
			}
		*/
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
            if ($error->errorInfo[1] == 1062) {                            // If it is a duplicate
	            $result = 'There is already a category that has this name - please try a different category name';
            } else {
				$result = $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
			}
		}
		return $result;                                                   // Say succeeded
	}

	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE category SET name = :name, description = :description WHERE id = :id';//SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindParam(':id', $this->id, PDO::PARAM_INT);           // Bind id
		$statement->bindParam(':name', $this->name);                       // Bind name
		$statement->bindParam(':description', $this->description);         // Bind description
		/*
			if($statement->execute()) {                                        // If executes
				return TRUE;                                                   // Say succeeded
			} else {                                                           // Otherwise
				return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
			}
		*/
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
            if ($error->errorInfo[1] == 1062) {                            // If it is a duplicate
	            $result = 'There is already a category that has this name - please try a different category name';
            } else {
				$result = $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
			}
		}
		return $result;                                                   // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM category WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		if($statement->execute()) {                                        // If executes
			return TRUE;                                                   // Say succeeded
		} else {                                                           // Otherwise
			return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
		}
	}
}

Class User {
	public  $id;
	public  $forename;
	public  $surname;
	public  $email;
	public  $password;
	public  $joined;
	public  $image;

	function __construct($id ='', $forename = NULL, $surname = NULL, $email = NULL, $password = NULL, $joined = NULL, $image = NULL) {
		$this->id       = ( isset($id)       ? $id       : '');
		$this->forename = ( isset($forename) ? $forename : '');
		$this->surname  = ( isset($surname)  ? $surname  : '');
		$this->email    = ( isset($email)    ? $email    : '');
		$this->password = ( isset($password) ? $password : '');
		$this->joined   = ( isset($joined)   ? $joined   : '');
		$this->image    = ( isset($image)    ? $image    : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO user (forname, surname, email, password) 
		        VALUES (:forname, :surname, :email, :password)';           // SQL
		$statement = $connection->prepare($sql);                           // Prepare
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

	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE category SET forename = :forename, surname = :surname, email = :email, password = :password, WHERE id = :id';//SQL
		$statement = $connection->prepare($sql);                           // Prepare
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

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM user WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		if($statement->execute()) {                                        // If executes
			return TRUE;                                                   // Say succeeded
		} else {                                                           // Otherwise
			return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
		}
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
	  if(preg_match_all('/[A-Z]/', $password)<1) { $error = TRUE; } // < 1 x A-Z return FALSE
	  if(preg_match_all('/[a-z]/', $password)<1) { $error = TRUE; } // < 1 x a-z return FALSE
	  if(preg_match_all('/\d/', $password)<1)    { $error = TRUE; } // < 1 x 0-9 return FALSE
	  if (isset($error)) {
	    return 'Your password must contain 2 uppercase letters, 2 lowercase letters, and a number. It must be between 8 and 32 characters.<br>';
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
		$errors['name']     = $this->isCategoryName($Category->name);
		$errors['template'] = $this->isCategoryTemplate($Category->template);
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
		$errors['media_id']    = $this->isID($Article->media_id);
		return $errors;
	}


	function isUser($User) {
		$errors = array('id'=>'', 'name'=>'', 'template'=>'');
		return $errors;
	}
}

?>