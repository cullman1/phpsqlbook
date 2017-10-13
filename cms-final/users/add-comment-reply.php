<?php 
session_start();
require_once('../config.php');
$article_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$reply_to_id = (filter_input(INPUT_GET, 'reply_to_id') ? $_GET['reply_to_id'] : '');
$parent_id   = (filter_input(INPUT_GET, 'parent_id')   ? $_GET['parent_id'] : '');
$comment    = (filter_input(INPUT_POST, 'comment') ? $_POST['comment'] : '');
$created    = date('Y-m-d H:i:s');
$comment    = filter_var($comment, FILTER_SANITIZE_STRING);
$reply_to_id = filter_var($reply_to_id, FILTER_SANITIZE_URL);
$parent_id   = filter_var($parent_id,   FILTER_SANITIZE_URL);
if (empty($article_id) || empty($reply_to_id) || empty($parent_id) ) {
    header( "Location: ../error-has-occurred.php" );
}
if ((mb_strlen($comment)>0) && (mb_strlen($comment)<2000)) {
    $comment = new Comment(0, $article_id, $_SESSION['user_id'], $comment, $created,
                         $reply_to_id, $parent_id);
    $result   = $articleManager->addComment($comment);
} else {
    $result   = 'Comments must be under 2000 characters.';
}
if ($result === TRUE) {
    header('Location: '. ROOT .  $articleManager->getArticleUrl($article_id) );
}
include('../includes/header.php'); 
echo 'We were unable to add your comment.<br>';
echo $result;
include('../includes/footer.php');
?>
