<?php 
session_start();
require_once('../includes/database-connection.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');
$user_id = ( isset($_GET['user_id']) ? $_GET['user_id'] : '' ); 
$article_id = ( isset($_GET['article_id']) ? $_GET['article_id'] : '' ); 
$likes = ( isset($_GET['likes']) ? $_GET['likes'] : 0 ); 
if ($likes==0) {
  if (add_like_by_id($user_id, $article_id)) {
    header('Location: /phpsqlbook/cms/' . get_article_url($article_id)); 
  }
}
if ($likes>0) {
  if (remove_like_by_id($user_id, $article_id)) {
    header('Location: /phpsqlbook/cms/' . get_article_url($article_id)); 
  }
}
?>