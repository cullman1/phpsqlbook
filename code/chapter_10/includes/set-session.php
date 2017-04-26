<?php
session_set_cookie_params(30*60, '/', '', false, true);
session_start();
$file = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['last_viewed'])) {
  $history = array($file);
  $_SESSION['last_viewed'] = $history;
} else {
  array_unshift($_SESSION['last_viewed'], $file);
  $_SESSION['last_viewed'] = array_unique($_SESSION['last_viewed']);
}
?>