<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
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

  function resize_image($path, $new_width, $new_height) {
    $file_type = exif_imagetype($path);                          // Get image type 
    list($current_width, $current_height) = getimagesize($path); // Get height and width of image 
    $ratio = $current_width / $current_height;                   // Get aspect ratio
    if ($new_width / $new_height > $ratio) {                     // If a portrait picture
      $new_width = $new_height * $ratio;                         // Set new width
    } else {                                                     // Otherwise is landscape / square
      $new_height = $new_width / $ratio;                         // Set new height
    }
    $imagick = new Imagick();
    $imagick->readImage($path);
    $imagick->thumbnailImage($new_width, $new_height);
    $file_ext = substr($path,-3);
            if ($file_ext=="peg") { $file_ext="jpeg";}
    $thumbpath = substr($path,0,-4)."_thumbnail.".$file_ext;

    $imagick->setImageFormat($file_ext);
    $imagick->writeImage('../uploads/' .$thumbpath);                             // Save image
    return $thumbpath;
  }

  function upload_file($connection, $file, $title, $alt) {
    $date      = date("Y-m-d H:i:s");       // Today's date
    $type      = $file['type'];             // Type of file from $_FILES superglobal
    $temporary = $file['tmp_name'];         // Temp file location $_FILES superglobal
    $filename  = $file['name'];             // Name of file from $_FILES superglobal
    $filepath  = '../uploads/' . $filename; // Filepath = relative directory + filename
    $thumb     = '';                        // See resize-image.php, it returns the path

    if(move_uploaded_file($temporary, $filepath)) {

      $thumb = resize_image($filepath, 150, 150);

      $sql = "INSERT INTO media(title, alt, date, type, filename, filepath, thumb) 
      VALUES (:title,:alt,:date,:type,:filename,:filepath,:thumb)";
      $statement = $GLOBALS['connection']->prepare($sql);            // Connect
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

  if ( empty($title) && empty($alt) ) {
    echo get_image_upload_form();
  } else { 
    echo upload_file($connection, $_FILES['image'], $title, $alt);
  }
?>