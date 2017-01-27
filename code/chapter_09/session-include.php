<?php
session_start();
session_set_cookie_params(30*60, '/', '', false, true);
$file = basename($_SERVER['PHP_SELF']);

function create_history($current) {
  $history = array();
  array_push($history, $current);
  return $history;
}

function remove_existing($current, $history) {
  foreach($history as $value=>$page) {         
    if ($page == $current) {
      unset($history[$value]);
    }
  }  
  return $history;
}

function add_current($current, $history) {
  array_unshift($history, $current);
  if (count($history) > 5) { 
    array_pop($history);
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