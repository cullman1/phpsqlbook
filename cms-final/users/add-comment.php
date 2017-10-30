<?php 
session_start();
require_once('../config.php');
$article_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$comment    = (filter_input(INPUT_POST, 'comment') ? $_POST['comment'] : '');
$created    = date('Y-m-d H:i:s');
$comment    = filter_var($comment, FILTER_SANITIZE_STRING);
if (empty($article_id)) {
    Utilities::errorPage('page-not-found.php');
}
$comment = trim($comment);
if ((mb_strlen($comment)>0) && (mb_strlen($comment)<2000)) {
    $comment  = new Comment(0, $article_id, $_SESSION['user_id'], $comment, $created);
    $result   = $articleManager->addComment($comment);
} else {
    $result   = 'Comments must be over 0 characters and under 2000 characters.';
}
if ($result === TRUE) {
    header('Location: '. ROOT .  $articleManager->getArticleUrl($article_id) );
    exit();
}
include('../includes/header.php'); 
echo '<section class="jumbotron text-center">';
echo '<div class="container"><h1 class="jumbotron-heading">We were unable to add your comment.</h1>'.$result ."</div>";
echo '</section>';
include('../includes/footer.php');
?>