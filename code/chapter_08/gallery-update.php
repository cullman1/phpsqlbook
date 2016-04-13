<?php    
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
header('Content-Type: application/json');   // Going to send back JSON

  $media_id   = (filter_input(INPUT_POST, 'mid', FILTER_VALIDATE_INT) ? $_POST['mid'] : ''); // Get and sanitize numbers
  $gallery_id = (filter_input(INPUT_POST, 'gid', FILTER_VALIDATE_INT) ? $_POST['gid'] : ''); // Get and sanitize numbers
  $checked    = $_POST['chk']; 

if (($media_id != '') && ($gallery_id != '')) {
  if ($checked == "true") {    // Did user check box (this is a string - not a boolean)
    if (insert_gallery_item($media_id, $gallery_id, $checked)){
      $response_array['status'] = 'success';  // Say that it worked
    } else {    	
      $response_array['status'] = 'failure';  // Say if failed
    }
  }
  if ($checked == "false") {   // Did user uncheck box (this is a string - not a boolean)
    if (delete_gallery_item($media_id, $gallery_id, $checked)){
      $response_array['status'] = 'success';  // Say that it worked     	
    } else {    	
      $response_array['status'] = 'failure';  // Say that it failed
    }
  }
  echo json_encode($response_array);          // Encode response as JSON
}
?>