<?php 
session_start();
require_once('../config.php');

$article_id = ( isset($_GET['id']) ? $_GET['id'] : '' ); 

if ((mb_strpos($_SERVER['REQUEST_URI'], '/like')) && (isset($_SESSION['user_id']))) {
  $articleManager->addLikeById($_SESSION['user_id'], $article_id);
}

if ((mb_strpos($_SERVER['REQUEST_URI'], '/unlike')) && (isset($_SESSION['user_id']))) {
    $articleManager->removeLikeById($_SESSION['user_id'], $article_id);
}

header('Location: '. ROOT . $articleManager->getArticleUrl($article_id)); 
?>