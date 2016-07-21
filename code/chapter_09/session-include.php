<?php
session_start();
$filename = basename($_SERVER["PHP_SELF"]);
$title = str_replace("session-", "", $filename);
$title = str_replace(".php", "", $title);
$current =array("filename"=>$filename,"title"=>$title);

function create_last_viewed($current) {
  $just_viewed = array();
  array_push($just_viewed, $current);
	return $just_viewed;
}

function remove_existing($current, $just_viewed) {
 foreach($just_viewed as $value=>$page) {         
  if ($page['filename'] == $current['filename']) {
      unset($just_viewed[$value]);
   }
 }  
 return $just_viewed;
}

function add_current($current, $just_viewed) {
echo "SIZE".sizeof($just_viewed);
if ( sizeof($just_viewed < 4 ) ) { 

    array_push($just_viewed, $current);
  } else {   
  echo "PUSH".sizeof($just_viewed);
    array_shift($just_viewed);
    array_push($just_viewed, $current);
  }
  return $just_viewed;
}

if (isset($_SESSION['just_viewed'])) {

 $just_viewed = $_SESSION['just_viewed'];
 $just_viewed = remove_existing($current,$just_viewed);
 $just_viewed = add_current($current, $just_viewed);
 $_SESSION['just_viewed'] = $just_viewed;
} else {

 $_SESSION['just_viewed']= create_last_viewed($current);
}

?>