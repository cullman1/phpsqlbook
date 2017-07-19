<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../includes/check-user.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');
require_once('../includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";

$article_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$reply_to_id   = (filter_input(INPUT_GET, 'reply_to') ? $_GET['reply_to'] : '');
$parent_id     = (filter_input(INPUT_GET, 'parent')   ? $_GET['parent'] : '');
$comment_id     = (filter_input(INPUT_GET, 'comment_id')   ? $_GET['comment_id'] : '');
$comment    = (filter_input(INPUT_POST, 'comment') ? $_POST['comment'] : '');
$user_id    = $_SESSION['user_id'];
$created    = date("Y-m-d H:i:s");

$comment    = filter_var($comment, FILTER_SANITIZE_STRING);
$reply_to   = filter_var($reply_to, FILTER_SANITIZE_URL);
$parent     = filter_var($parent, FILTER_SANITIZE_URL);

$comment_id = str_replace("comment-","",$comment_id);
$reply_to_id = str_replace("reply-","",$reply_to_id);
$parent_id = str_replace("parent-","",$parent_id);

if ((strlen($comment)>0) && (strlen($comment)<2000)) {
$reply_to_id = $comment_id;
$parent_id   = (($parent_id == 0) ? $reply_to_id : $parent_id);
  $Comment = new Comment(0, $article_id, $_SESSION['user_id'], $comment, $created,  $reply_to_id, $parent_id);
 $result = $Comment->add();
} else {
  $result = 'Comments must be under 2000 characters.';
}
if ($result == TRUE) {
  header('Location: ' . get_article_url($article_id) );
}

include('../includes/header.php'); 
echo 'We were unable to add your comment.<br>';
echo $result;
include('../includes/footer.php');
?>