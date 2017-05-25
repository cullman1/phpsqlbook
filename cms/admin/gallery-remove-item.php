<?php    
header('Content-Type: application/json');   // Going to send back JSON

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

require_once('includes/check-user.php');                         // Is logged in
require_once('../includes/database-connection.php');             // DB connection
require_once('../includes/class-lib.php');                       // Classes
require_once('../includes/functions.php');                       // Functions
delete_gallery_item(42, 2);

$media_id   = (filter_input(INPUT_POST, 'mid', FILTER_VALIDATE_INT) ? $_POST['mid'] : ''); // Get and sanitize numbers
$gallery_id = (filter_input(INPUT_POST, 'gid', FILTER_VALIDATE_INT) ? $_POST['gid'] : ''); // Get and sanitize numbers

if (($media_id != '') && ($gallery_id != '')) {
  if (delete_gallery_item($media_id, $gallery_id)){ 
    $response_array['status'] = 'success';  // Say that it worked
  } else {      
    $response_array['status'] = 'failure';  // Say if failed
  }
  echo json_encode($response_array);          // Encode response as JSON
}
?>