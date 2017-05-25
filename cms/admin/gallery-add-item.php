<?php    
header('Content-Type: application/json');   // Going to send back JSON

require_once('includes/check-user.php');                         // Is logged in
require_once('../includes/database-connection.php');             // DB connection
require_once('../includes/class-lib.php');                       // Classes
require_once('../includes/functions.php');                       // Functions

$media_id   = (filter_input(INPUT_POST, 'media', FILTER_VALIDATE_INT) ? $_POST['media'] : ''); // Get and sanitize numbers
$gallery_id = (filter_input(INPUT_POST, 'gallery', FILTER_VALIDATE_INT) ? $_POST['gallery'] : ''); // Get and sanitize numbers

if (($media_id != '') && ($gallery_id != '')) {
  if (insert_gallery_item($media_id, $gallery_id)){ 
    $response_array['status'] = 'success';  // Say that it worked
  } else {      
    $response_array['status'] = 'failure';  // Say if failed
  }
  echo json_encode($response_array);          // Encode response as JSON
}
?>