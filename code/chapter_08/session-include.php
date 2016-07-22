<?php
session_start();
$file    = basename($_SERVER['PHP_SELF']);

function create_history($current) {
  $history = array();
  array_push($history, $current);
    return $history;
}

function remove_existing($file, $history) {
  foreach($history as $value=>$page) {         
    if ($page == $file) {
      unset($history[$value]);
    }
  }  
  return $history;
}

function add_current($current, $history) {
echo "SIZE". sizeof($history);
  if ( sizeof($history < 3 ) ) { 
    array_push($history, $current);
  } else {   
    array_unshift($history);
    array_push($history, $current);
  }
  return $history;
}

if (!isset($_SESSION['last_viewed'])) {
  $_SESSION['last_viewed'] = create_history($file);
} else {
  $history = $_SESSION['last_viewed'];
  $history = remove_existing($file, $history);
  $history = add_current($file, $history);
  $_SESSION['last_viewed'] = $history;
}