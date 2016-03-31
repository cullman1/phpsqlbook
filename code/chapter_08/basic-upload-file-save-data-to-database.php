<?php 
  require_once('includes/database-connnection.php'); 
  ini_set('display_errors', TRUE);
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

 function upload_file($file, $title, $alt) {
  $date      = date("Y-m-d H:i:s");       // Today's date
  $type      = $file['type'];             // Type of file from $_FILES superglobal
  $temporary = $file['tmp_name'];         // Temp file location $_FILES superglobal
  $filename  = $file['name'];             // Name of file from $_FILES superglobal
  $filepath  = '../uploads/' . $filename;    // Filepath = relative directory + filename
  $thumb     = '';                        // Will be added on pXXX

  if(move_uploaded_file($temporary, $filepath)) {  // Try to move file, if it works
    $sql = "INSERT INTO media(title, alt, date, type, filename, filepath, thumb) VALUES (:title,:alt,:date,:type,:filename,:filepath,:thumb)";  // Create SQL
    $statement = $GLOBALS['connection']->prepare($sql);            // Connect
    $statement->bindParam(":title",    $title);                    // Bind parameters
    $statement->bindParam(":alt",      $alt);
    $statement->bindParam(":date",     $date);
    $statement->bindParam(":type",     $type);
    $statement->bindParam(":filename", $filename);
    $statement->bindParam(":filepath", $filepath);
    $statement->bindParam(":thumb",    $thumb);
    $statement->execute();                                       // Execute
    if($statement->errorCode()==0) {                             // If no errors
      return $filename . ' uploaded successfully';               // Return success msg
    } else {                                                     // Otherwise
      return 'Information about your file could not be saved.';  // Say info not saved
    }
  } else {                                                        // Couldn't move file
    return 'Your image could not be saved.';                      // Say image not saved
  }
}
 if( isset($_FILES['image']) ) {    // If file present get title and alt text
      $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS); // Get file title
      $alt   = filter_input(INPUT_POST, 'alt', FILTER_SANITIZE_SPECIAL_CHARS);   // Get alt text
  }
 
  if ( empty($title) || empty($alt) ) { //
    echo get_image_upload_form();
  } else { 
    echo upload_file($_FILES['image'], $title, $alt);
  }
?>