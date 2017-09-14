<?php 
session_start();
require_once('../config.php');
$article_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$comment    = (filter_input(INPUT_POST, 'comment') ? $_POST['comment'] : '');
$user_id    = $_SESSION['user_id'];
$created    = date('Y-m-d H:i:s');
$comment    = filter_var($comment, FILTER_SANITIZE_STRING);
if ((strlen($comment)>0) && (strlen($comment)<2000)) {
    $comment  = new Comment(0, $article_id, $user_id, $comment, $created);
    $result   = $articleManager->addComment($comment);
} else {
    $result   = 'Comments must be under 2000 characters.';
}
if ($result == TRUE) {
    header('Location: '. ROOT .  $articleManager->getArticleUrl($article_id) );
}
include('../includes/header.php'); 
echo 'We were unable to add your comment.<br>';
echo $result;
include('../includes/footer.php');
?>
