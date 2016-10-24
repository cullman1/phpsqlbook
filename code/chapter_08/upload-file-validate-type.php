<?php 
  require_once('includes/database-connnection.php'); 

  function validate_file_type($filetype){
    $valid_types = array("image/jpeg", "image/png", "image/gif"); // Valid MIME types
    if (in_array($filetype, $valid_types)) {                      // If a valid format
      return $filetype;                                           // Return MIME type
    } else {                                                      // Otherwise
      return false;                                               // Return false
    }
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
    $filepath  = 'uploads/' . $filename;    // Filepath = relative directory + filename
    $thumb     = '';                        // Will be added on pXXX

    if( validate_file_type($type) == false ) {                 // If file not valid type
      return 'We cannot use this type of file.';               // Return error message
    } else {                                                   // Otherwise
      if(move_uploaded_file($temporary, $filepath) ) {         // Attempt to upload
        return '<img src="' . $filepath . '" alt="' . $alt . '" />'; // Show image
      } else {                                                 // Couldn't move file
        return 'Your image could not be saved.';               // Tell user not saved
      }
    }
  }

  if( isset($_FILES['image']) ) {    // If file present get title and alt text
      $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS); // Get file title
      $alt   = filter_input(INPUT_POST, 'alt', FILTER_SANITIZE_SPECIAL_CHARS);   // Get alt text
  }

  if ( empty($title) || empty($alt) ) {
    echo get_image_upload_form();
  } else { 
    echo upload_file($_FILES['image'], $title, $alt);
  }
?>