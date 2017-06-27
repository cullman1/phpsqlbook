<?php 
session_start();
require_once('../includes/database-connection.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');
$article_id = ( isset($_GET['article_id']) ? $_GET['article_id'] : '' ); 
if ((strpos($_SERVER["REQUEST_URI"], '/like')) && (isset($_SESSION['user_id']))) {
  if (add_like_by_id($_SESSION['user_id'], $article_id)) {
    header('Location: /phpsqlbook/cms/' . get_article_url($article_id)); 
  }
}
if ((strpos($_SERVER["REQUEST_URI"], '/unlike')) && (isset($_SESSION['user_id']))) {
  if (remove_like_by_id($_SESSION['user_id'], $article_id)) {
    header('Location: /phpsqlbook/cms/' . get_article_url($article_id)); 
  }
}
?>