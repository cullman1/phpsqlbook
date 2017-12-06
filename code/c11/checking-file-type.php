<?php
$alert = '';
function isAllowedMediaType($file) {       //Must include extension=php_fileinfo.dll first in php.ini   
      if (function_exists('mime_content_type')) {
          $mimeType = mime_content_type($file); 
          $allowedmedia_types = array('image/jpeg', 'image/png', 'image/gif'); // Allowed
          if (in_array($mimeType, $allowedmedia_types)) {          // If type is in list
              return TRUE;                                            // Blank error message
          }
      }
      return FALSE;
    }
if ( ($_SERVER['REQUEST_METHOD'] == 'POST') ) {
    if ( !file_exists($_FILES['image']['tmp_name']) ||  !is_uploaded_file($_FILES['image']['tmp_name'])) {            // or not uploaded
        $alert = '<div class="alert alert-danger">Upload failed.</div>'; // Store Error
    } else {
        $result = isAllowedMediaType($_FILES['image']['tmp_name']);                 
        if ((!$result) ) { // If $media_type is set and not valid
          $alert ="Not valid media type";                             // Show error message from function
        } else {                                        // Otherwise
          $alert = 'Valid media type';                  // Store success message
        }
    }
    echo $alert;                                      // Display message
}
?>
<form method="post" enctype="multipart/form-data"><br />
   <label for="file">Upload file: </label>
                  <input type="file" name="image" accept="image/*" id="image" value="Choose file" />  <br /><br />
    <input type="submit" />
                  </form>