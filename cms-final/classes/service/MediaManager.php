<?php

class MediaManager {
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function moveImage($filename, $temporary) {
    $moved = move_uploaded_file($temporary, '../' . UPLOAD_DIR . $filename);    // Try to move uploaded file
    if ($moved == FALSE) {
      return 'Could not save image.';
    }
    return TRUE;
  }

    public function deleteImage($media_id) {
    $pdo = $this->pdo;
    $pdo->beginTransaction();
    try {
      $sql = 'select * FROM media WHERE id = :id';
      $statement = $pdo->prepare($sql);                                 // Prepare
      $statement->bindValue(':id',   $media_id);                 // Bind value
      $statement->execute();  
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Media');     // Object
      $image = $statement->fetch();

      $sql = 'DELETE FROM media WHERE id = :id';
      $statement = $pdo->prepare($sql);                                 // Prepare
      $statement->bindValue(':id',    $media_id);               // Bind value
      $statement->execute();                                            // Try to execute

      $sql = 'DELETE FROM articleimages WHERE media_id = :id';
      $statement = $pdo->prepare($sql);                                 // Prepare
      $statement->bindValue(':id',   $media_id);                 // Bind value
      $statement->execute();                                         // Try to execute

      $pdo->commit();
   

      if ($image) {
        if(file_exists('../uploads/'. $image->filename)) {

          unlink('../uploads/'. $image->filename); // deletes file
          unlink('../uploads/thumb/'. $image->filename);

        }        
      } 
      $result = TRUE;
    } catch (PDOException $error) {                                  // Otherwise
      $pdo->rollBack();
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error <-- cannot show this
    }
    return $result;
  }

  public function saveImage($article_id, $media) {
    $pdo = $this->pdo;
    $pdo->beginTransaction();
    try {
      $sql = 'INSERT INTO media ( alt,  filename) 
	     	  VALUES ( :alt, :filename)';
      $statement = $pdo->prepare($sql);                                 // Prepare
      $statement->bindValue(':alt',       $media->alt);                 // Bind value
      $statement->bindValue(':filename',  $media->filename);            // Bind value
      $statement->execute();                                            // Try to execute
      $media->id = $pdo->lastInsertId();                                // Add id to object

      $sql = 'INSERT INTO articleimages (article_id,  media_id) 
	    	                           VALUES (:article_id, :media_id)';
      $statement = $pdo->prepare($sql);                                 // Prepare
      $statement->bindValue(':article_id', $article_id);               // Bind value
      $statement->bindValue(':media_id',   $media->id);                 // Bind value
      $statement->execute();                                         // Try to execute

      $pdo->commit();
      $result = TRUE;
    } catch (PDOException $error) {                                  // Otherwise
      $pdo->rollBack();
      $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error <-- cannot show this
    }
    return $result;
  }

  public function resizeImage($filename, $new_width, $thumb = NULL) {
    $current_image  = '../' . UPLOAD_DIR . $filename;            // Path to current image
    if ($thumb != TRUE) {
      $save_location = $current_image;
    } else {
      $save_location = '../' . UPLOAD_DIR . 'thumb/' . $filename;
    }
    $image_details  = getimagesize($current_image);              // Get file information
    $file_type      = $image_details['mime'];                    // Get image type
    $current_width  = $image_details[0];                         // Get width
    $current_height = $image_details[1];                         // Get height
    $ratio          = $current_width / $current_height;          // Get ratio of image
    $new_height   = $new_width / $ratio;                       // Set new height

    switch($file_type) {
      case 'image/gif':
        $current_image = imagecreatefromgif($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagegif($new_image, $save_location);                               // Save image
        return TRUE;
      case 'image/png':
        $current_image = imagecreatefrompng($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagepng($new_image, $save_location);                               // Save image
        return TRUE;
      default:
        $current_image = imagecreatefromjpeg($current_image);           // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagejpeg($new_image, $save_location);                              // Save image
        return TRUE;
    }
    return 'Could not create thumbnail.';
  }

  public function resizeImageOG($filename, $new_width, $new_height, $thumb = NULL) {
    $current_image  = '../' . UPLOAD_DIR . $filename;            // Path to current image
    if ($thumb != TRUE) {
      $save_location = $current_image;
    } else {
      $save_location = '../' . UPLOAD_DIR . 'thumb/' . $filename;
    }
    $image_details  = getimagesize($current_image);              // Get file information
    $file_type      = $image_details['mime'];                    // Get image type
    $current_width  = $image_details[0];                         // Get width
    $current_height = $image_details[1];                         // Get height
    $ratio          = $current_width / $current_height;          // Get ratio of image
    $new_ratio      = $new_width / $new_height;                  // Get ratio of thumb

    if ($new_ratio > $ratio) {                                   // If new is greater
      $new_width    = $new_height * $ratio;                      // Set new width
    } else {                                                     // Else
      $new_height   = $new_width / $ratio;                       // Set new height
    }

    switch($file_type) {
      case 'image/gif':
        $current_image = imagecreatefromgif($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagegif($new_image, $save_location);                               // Save image
        return TRUE;
      case 'image/png':
        $current_image = imagecreatefrompng($current_image);            // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagepng($new_image, $save_location);                               // Save image
        return TRUE;
      default:
        $current_image = imagecreatefromjpeg($current_image);           // Current image
        $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
        imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height,
            $current_width, $current_height);            // Resize image
        imagejpeg($new_image, $save_location);                              // Save image
        return TRUE;
    }
    return 'Could not create thumbnail.';
  }

}