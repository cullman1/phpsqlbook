<?php
  $alert = '';
   function isAllowedExtension($filename) {       // Check file extension
    $filename = mb_strtolower($filename);
    if (!preg_match('/.(jpg|jpeg|png|gif)$/', $filename) ) {    // If not file extension
      return FALSE;
    }
    return TRUE;                                               // Return error
  }
   function isAllowedFilename($text) {
    $result = preg_replace('/[^A-z0-9 \.,!\?\'\"#\$%&*\(\)\+\-\/]/', '', $text); 
    if ($result != $text ) {
      return FALSE;
    }
    return TRUE;
  } 
   if ( ($_SERVER['REQUEST_METHOD'] == 'POST') ) {                      // If form sent
       if ( !file_exists($_FILES['image']['tmp_name']) ||  !is_uploaded_file($_FILES['image']['tmp_name'])) {            // or not uploaded
           $alert = '<div class="alert alert-danger">Upload failed.</div>'; // Store Error
       } else {
           $result1 = isAllowedExtension($_FILES['image']['name']); 
           $result2 = isAllowedFilename($_FILES['image']['name']);
           if (!($result1 && $result2)) {                              // If $result is false
               $alert = 'Not valid media name';              // Show error message from function
           } else {                                        // Otherwise
               $alert = 'Valid media name';                  // Store success message
           }
       }
   }
echo $alert;                                        // Display message
?> 
<form method="POST" action="" enctype="multipart/form-data">
    <label for="image">Upload file: </label>
    <input type="file" name="image" accept="image/*" id="image" />
    <button type="submit" name="sent" value="sent">Submit</button>
</form>
