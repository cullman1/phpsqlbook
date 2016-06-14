<?php
session_start();

$filename      = basename($_SERVER["PHP_SELF"]);
$title         = str_replace("session-","",$filename);
$title         = str_replace(".php","",$title);
$current_page  = array("filename"=>$filename, "title"=>$title);

function create_last_viewed($current_page) {
  $recently_viewed = array();
  array_push($recently_viewed, $current_page);
	return $recently_viewed;
}

function remove_existing_page($current_page, $recently_viewed) {
  foreach($recently_viewed as $value=>$page) {           // loop through items and remove it if current one remove it
    if ($page['filename'] == $current_page['filename']) {
      unset($recently_viewed[$value]);
    }
  }  
	return $recently_viewed;
}

function add_current_page($current_page, $recently_viewed) {
  if ( sizeof($recently_viewed < 4 ) ) { //Less then 3 items so we need to add one
    array_push($recently_viewed, $current_page);
  } else {   //3 items so remove the oldest and add one
    array_shift($recently_viewed);
    array_push($recently_viewed, $current_page);
  }
	return $recently_viewed;
}

if (isset($_SESSION["recently_viewed"])) { 
$recently_viewed = $_SESSION["recently_viewed"]; 
   $recently_viewed = remove_existing_page($current_page, $recently_viewed);   
   $recently_viewed = add_current_page($current_page, $recently_viewed);  
	 $_SESSION['recently_viewed'] = $recently_viewed;
} else {
   $_SESSION['recently_viewed'] = create_last_viewed($current_page);
}

?>