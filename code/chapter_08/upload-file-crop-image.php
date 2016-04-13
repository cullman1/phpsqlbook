<?php
  require_once('includes/database-connnection.php'); 

  function clean($content) {
    $content = trim($content);
    $content = htmlspecialchars($content);
    return $content;
  }

  function get_image_upload_form(){
    $form = '<form method="post" action="" enctype="multipart/form-data">
      <label>Title: <input type="text" name="title" /></label><br>
      <label>Alt text: <input type="text" name="alt" /></label><br>
      <label>Image: <input type="file" name="image" accept="image/*" /></label><br>
      <button type="submit" name="submitted" value="sent">Submit</button>
    </form>';
    return $form;
  }

  function create_new_path($path, $addition) {
    $file_type = exif_imagetype($path);                          // Get image type 
    switch($file_type) {
      case 1:
        $newpath = substr($path,0,-4) . $addition . ".gif";      // Thumbnail path
        return $newpath;
      case 2:
        if (substr($path,-4) == '.jpg' ){                        // .jpg extension
          $newpath = substr($path,0,-4) . $addition . ".jpg";    // Thumbnail path
        } else {                                                 // Else .jpeg
          $newpath = substr($path,0,-5) . $addition . ".jpeg";   // Thumbnail path
        }
        return $newpath;
      case 3:
        $newpath = substr($path,0,-4) . $addition . ".png";      // Thumbnail path
        return $newpath;
    }
    return '';
  }

  function crop_image($path, $new_width, $new_height) {          // Declare function
    $image = new Imagick($path);                                 // Object to represent image
    $current_height = $image->getImageHeight();                  // Get current image height
    $current_width  = $image->getImageWidth();                   // Get current image width
    if ($current_height > $current_width) {                      // If portrait
      $current_height = $current_width;                          // Make height same as width
    } else {                                                     // Else landscape
      $current_width = $current_height;                          // Make width same as height
    }
    $image->cropImage($current_width, $current_height, 0, 0);    // Create crop
    $image->thumbnailImage($new_width, $new_height);             // Create thumbnail
    $last_period = strrpos($path, '.');                          // Last period in filename
    $croppedpath = create_new_path($path, '_cropped');           // Update filename / path
    $image->writeImage($croppedpath);                            // Save file
    return $croppedpath;                                         // Return new path
  }

  function upload_file($connection, $file, $title, $alt) {
    $date      = date("Y-m-d H:i:s");       // Today's date
    $type      = $file['type'];             // Type of file from $_FILES superglobal
    $temporary = $file['tmp_name'];         // Temp file location $_FILES superglobal
    $filename  = $file['name'];             // Name of file from $_FILES superglobal
    $filepath  = '../uploads/' . $filename; // Filepath = relative directory + filename
    $thumb     = '';                        // See resize-image.php, it returns the path

    if(move_uploaded_file($temporary, $filepath)) {

      $thumb = crop_image($filepath, 150, 150);

      $sql = "INSERT INTO media(title, alt, date, type, filename, filepath, thumb) 
      VALUES (:title,:alt,:date,:type,:filename,:filepath,:thumb)";
      $statement =$connection->prepare($sql);
      $statement->bindParam(":title",    $title);
      $statement->bindParam(":alt",      $alt);
      $statement->bindParam(":date",     $date);
      $statement->bindParam(":type",     $type);
      $statement->bindParam(":filename", $filename);
      $statement->bindParam(":filepath", $filepath);
      $statement->bindParam(":thumb",    $thumb);
      $statement->execute();
      if($statement->errorCode()==0) {
          return '<img src="' . $thumb . '"><br/>'. $filename . ' ' . $thumb . ' uploaded successfully';
      } else {
        return 'Information about your file could not be saved.';
      }
    } else { 
      return 'Your image could not be saved.';
    }
  }

  if( isset($_FILES['image']) ) {
      $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS); // Get file title
      $alt   = filter_input(INPUT_POST, 'alt', FILTER_SANITIZE_SPECIAL_CHARS);   // Get alt text
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Upload file / show info</title>
  </head>
  <body>
  <?php
    if(extension_loaded('imagick')) {
      $im = new Imagick();
      echo 'ImageMagick is installed.';
    } else {
      echo 'ImageMagick is not installed.';
    }

    if ( empty($title) && empty($alt) ) {
      echo get_image_upload_form();
    } else { 
      echo upload_file($connection, $_FILES['image'], $title, $alt);
    }
  ?>
  </body>
  </html>