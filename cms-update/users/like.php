<?php 
session_start();
require_once('../config.php');

$article_id = ( isset($_GET['id']) ? $_GET['id'] : '' ); 
if ((mb_strpos($_SERVER['REQUEST_URI'], '/like')) && (isset($_SESSION['user_id']))) {
  $status = $articleManager->getLikeStatus($_SESSION['user_id'], $article_id);
  if ($status) {
    $articleManager->addLikeById($_SESSION['user_id'], $article_id);
  } else {
    $articleManager->removeLikeById($_SESSION['user_id'], $article_id);
  }
}
header('Location: '. ROOT . $articleManager->getArticleUrl($article_id)); 
?>