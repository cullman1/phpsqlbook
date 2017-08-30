<?php

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

Class Category {
	public  $id;
	public  $name;
	public  $description;
    public  $template;
	public  $count;

	function __construct($id ='', $name = NULL, $description = NULL, $template = NULL) {
		$this->id          = ( isset($id)          ? $id       : '');
		$this->name        = ( isset($name)        ? $name     : '');
		$this->description = ( isset($description) ? $description : '');
        $this->template = ( isset($template) ? $template : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO category (name, description) VALUES (:name, :description)'; // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':name', $this->name);                       // Bind name
		$statement->bindValue(':description', $this->description);         // Bind description
		try {
			$statement->execute();                                         // Execute SQL
			$this->id = $connection->lastInsertId();                       // Add id to object
			$result   = TRUE;                                              // Get id created
		}
        catch (PDOException $error) {                                    // Otherwise
            if ($error->errorInfo[1] == 1062) {                            // If it is a duplicate
	            $result = 'A category with that name exists - try a different name';
            } else {
                $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
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
		try {
			$statement->execute();
			$result = TRUE;
		}
        catch (PDOException $error) {                                    // Otherwise
            if ($error->errorInfo[1] == 1062) {                            // If it is a duplicate
	            $result = 'A category with that name exists - try a different name';
            } else {
                $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
			}
		}
		return $result;                                                   // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM category WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		try {
			$statement->execute();                                         // If executes
			return TRUE;                                                   // Say succeeded
		}
        catch (PDOException $error) {                                    // Otherwise
            $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
	}
}

/* Class User {
	public  $id;
	public  $forename;
	public  $surname;
	public  $email;
	public  $password;
	// Joined is automatically added when created
	// Image will be added in next chapter
	public  $authoredArticles; // gets an article summary object
	public  $likedArticles;    // gets an article summary object

	function __construct($id ='', $forename = NULL, $surname = NULL, $email = NULL, $password = NULL) {
		$this->id       = ( isset($id)       ? $id       : '');
		$this->forename = ( isset($forename) ? $forename : '');
		$this->surname  = ( isset($surname)  ? $surname  : '');
		$this->email    = ( isset($email)    ? $email    : '');
		$this->password = ( isset($password) ? $password : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO user (forname, surname, email, password) 
		        VALUES (:forname, :surname, :email, :password)';           // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':forename', $this->forename);               // Bind value
		$statement->bindValue(':surname',  $this->surname);                // Bind value
		$statement->bindValue(':email',    $this->email);                  // Bind value
		$statement->bindValue(':password', $this->password);               // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
      		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
		return $result;                                                   // Say succeeded
	}

	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE gallery SET name = :name, mode = :mode WHERE id = :id'; //SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id',   $this->id);                         // Bind value
		$statement->bindValue(':name', $this->name);                       // Bind value
		$statement->bindValue(':mode',  $this->mode);        // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
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
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
	}
} */

Class Media {
	public  $id;
	public  $name;
	public  $title;
	public  $alt;
	public  $created;
	public  $mediatype;
	public  $filename;
	public  $filepath;
	public  $filesize;
	public  $thumb;

	function __construct($id ='', $title = NULL, $alt = NULL, $mediatype = NULL, $filename = NULL, $filepath = NULL, $thumb = NULL) {
		$this->id        = ( isset($id)        ? $id        : '');
		$this->title     = ( isset($title)     ? $title     : '');
		$this->alt       = ( isset($alt)       ? $alt       : '');
		$this->mediatype = ( isset($mediatype) ? $mediatype : '');
		$this->filename  = ( isset($filename)  ? $filename  : '');
		$this->filepath  = ( isset($filepath)  ? $filepath  : '');
		$this->thumb     = ( isset($thumb)     ? $thumb     : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO media (title, alt, mediatype, filename, filepath, thumb) 
		        VALUES (:title, :alt, :mediatype, :filename, :filepath, :thumb)'; // SQL
		$statement = $connection->prepare($sql);               // Prepare
		$statement->bindValue(':title',     $this->title);     // Bind value
		$statement->bindValue(':alt',       $this->alt);       // Bind value
		$statement->bindValue(':mediatype', $this->mediatype); // Bind value
		$statement->bindValue(':filename',  $this->filename);  // Bind value
		$statement->bindValue(':filepath',  $this->filepath);  // Bind value
		$statement->bindValue(':thumb',     $this->thumb);     // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
      		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
		return $result;                                                   // Say succeeded
	}

	function createCroppedThumbnail($path, $new_width, $new_height) {       // Declare function
	  $image = new Imagick($path);                              // Object to represent image
	  $current_height = $image->getImageHeight();               // Get current image height
	  $current_width  = $image->getImageWidth();                // Get current image width
	  if ($current_height > $current_width) {                   // If portrait
	    $current_height = $current_width;                       // Make height same as width
	  } else {                                                  // Else landscape
	    $current_width = $current_height;                       // Make width same as height
	  }
	  $image->cropImage($current_width, $current_height, 0, 0); // Create crop
	  $image->thumbnailImage($new_width, $new_height);          // Create thumbnail
	  $croppedpath = create_new_path($path, $addition);         // Update filename / path
	  $image->writeImage($path);                                // Save file
	  return $path;                                             // Return new path
	}

	function createThumbnailGD($filename, $directory, $new_width, $new_height) {
	  $current_image  = $directory . $filename;                   // Path to current image
	  $thumbpath      = $directory . 'thumbs/' . $filename;       // Path to thumbnail
	  $image_details  = getimagesize($current_image);             // Get file information
	  $file_type      = $image_details['mime'];                   // Get image type
	  $current_width  = $image_details[0];                        // Get width 
	  $current_height = $image_details[1];                        // Get height
	  $ratio          = $current_width / $current_height;         // Get ratio of image
	  $new_ratio      = $new_width / $new_height;                 // Get ratio of thumb

	  if ($new_ratio > $ratio) {                                  // If new is greater
	    $new_width    = $new_height * $ratio;                     // Set new width
	  } else {                                                    // Else
	    $new_height   = $new_width / $ratio;                      // Set new height
	  }

	  switch($file_type) {
	    case 1:
	      $current_image = imagecreatefromgif($current_image);            // Current image
	      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
	      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
	                         $current_width, $current_height);            // Resize image
	      imagegif($new_image, $thumbpath);                               // Save image
	      return $thumbpath;
	    case 2:
	      $current_image = imagecreatefromjpeg($current_image);           // Current image
	      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
	      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
	                         $current_width, $current_height);            // Resize image
	      imagejpeg($new_image, $thumbpath);                              // Save image
	      return $thumbpath;
	    case 3:
	      $current_image = imagecreatefrompng($current_image);            // Current image
	      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
	      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
	                         $current_width, $current_height);            // Resize image
	      imagepng($new_image, $thumbpath);                               // Save image
	      return $thumbpath;
	  }
	  return '';
	}


	function update() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'UPDATE media SET title = :title, alt = :alt, created = :created, mediatype = :mediatype, filename = :filename, filepath = filepath, thumb = thumb WHERE id = :id'; //SQL
		$statement = $connection->prepare($sql);               // Prepare
		$statement->bindValue(':id',        $this->id);        // Bind value
		$statement->bindValue(':title',     $this->title);     // Bind value
		$statement->bindValue(':alt',       $this->alt);       // Bind value
		$statement->bindValue(':created',   $this->created);   // Bind value
		$statement->bindValue(':mediatype', $this->mediatype); // Bind value
		$statement->bindValue(':filename',  $this->filename);  // Bind value
		$statement->bindValue(':filepath',  $this->filepath);  // Bind value
		$statement->bindValue(':thumb',     $this->thumb);     // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
		return $result;                                                   // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM media WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		if($statement->execute()) {                                        // If executes
			return TRUE;                                                   // Say succeeded
		} else {                                                           // Otherwise
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
	}
}

Class Gallery {
	public $id;
	public $name;
	public $mode;
	public $items;

	function __construct($id = '', $name = NULL, $mode = NULL, $items = NULL) {
		$this->id    = ( isset($id)    ? $id    : '');
		$this->name  = ( isset($name)  ? $name  : '');
		$this->mode  = ( isset($mode)  ? $mode  : '');
	}

	function create() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'INSERT INTO gallery (name, mode) 
		        VALUES (:name, :mode)'; // SQL
		$statement = $connection->prepare($sql);                   // Prepare
		$statement->bindValue(':name', $this->name);        // Bind value
		$statement->bindValue(':mode', $this->mode); // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
      		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
		return $result;                                                   // Success / fail
	}

	function update() {
		$connection = $GLOBALS['connection'];                             // Connection
		$sql = 'UPDATE gallery SET name = :name, mode = :mode WHERE id = :id'; //SQL
		$statement = $connection->prepare($sql);                          // Prepare
		$statement->bindValue(':id',          $this->id);                 // Bind value
		$statement->bindValue(':name',        $this->name);               // Bind value
		$statement->bindValue(':mode', $this->mode);        // Bind value
		try {
			$statement->execute();
			$result = TRUE;
		} catch (PDOException $error) {                                    // Otherwise
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}
		return $result;                                                   // Say succeeded
	}

	function delete() {
		$connection = $GLOBALS['connection'];                              // Connection
		$sql = 'DELETE FROM gallery WHERE id = :id';                      // SQL
		$statement = $connection->prepare($sql);                           // Prepare
		$statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
		if($statement->execute()) {                                        // If executes
			$result = TRUE;                                                   // Say succeeded
		} else {                                                           // Otherwise
     		$result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
		}		
		return $result;
	}

	function getGalleryContent() { // This has to change to a media list object
	  $query = 'SELECT * FROM galleryitems WHERE gallery_id = :gallery_id ORDER BY priority'; // Query
	  $statement = $GLOBALS['connection']->prepare($query);    // Prepare
	  $statement->bindParam(":gallery_id", $this->id, PDO::PARAM_INT);         // Bind
	  $statement->execute();                                   // Execute
	  $statement->setFetchMode(PDO::FETCH_OBJ);                // Step 4 Set fetch mode to object
	  $this->items = $statement->fetchAll();                  // Get data
	}

	function getGalleryModeName() {
	  $gallery_type = Array('Thumbnail', 'Slider');
  	  return $gallery_type[$this->mode];
	}

	function getFirstImage() {
		$connection = $GLOBALS['connection'];       // Connection
		$query = 'SELECT media_id FROM galleryitems 
		          WHERE gallery_id = :gallery_id  LIMIT 1';           // Query
		$statement = $connection->prepare($query);                           // Prepare
  		$statement->bindValue(':gallery_id', $this->id);   // Bind value from query string
		$statement->execute();                                   // Execute
		$first_media = $statement->fetchColumn();

		$query = 'SELECT * FROM media WHERE id = :id';           // Query
  		$statement = $connection->prepare($query); 
  		$statement->bindValue(':id', $first_media, PDO::PARAM_INT);   // Bind value from query string
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

    function isImage($image) {
        $error = '';
        if (($this->stringLength($image, 1, 255)) == FALSE ) {
            $error = 'You cannot have a blank image.<br>';
        }
        return $error;
    }

	function isUser($User) {
		$errors    = array('id' => '', 'forename' => '', 'surname'=>'', 'email'=>'', 'image'=>'', 'password'=>'');    // Form errors
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
}

?>