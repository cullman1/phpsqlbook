<?php // include files go here
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../includes/check-user.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');
require_once('../includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$article_id  = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$reply_to_id = (filter_input(INPUT_GET, 'reply_to_id') ? $_GET['reply_to_id'] : '');
$parent_id   = (filter_input(INPUT_GET, 'parent_id')   ? $_GET['parent_id'] : '');
$comment     = (filter_input(INPUT_POST, 'comment') ? $_POST['comment'] : '');
$user_id     = $_SESSION['user_id'];
$created     = date('Y-m-d H:i:s');

if ((strlen($comment)<1) || (strlen($comment)>2000)) {
  $result = 'Comments must be under 2000 characters.';
} else {
  $comment     = filter_var($comment,     FILTER_SANITIZE_STRING);
  $reply_to_id = filter_var($reply_to_id, FILTER_SANITIZE_URL);
  $parent_id   = filter_var($parent_id,   FILTER_SANITIZE_URL);

  $Comment = new Comment(0, $article_id, $user_id, $comment, $created,
                         $reply_to_id, $parent_id);
               
 $result = $Comment->add();
}
if ($result == TRUE) { 
 header('Location: ' . get_article_url($article_id) ); 
}
include('../includes/header.php'); 
echo 'We were unable to add your comment.<br>' . $result;
include('../includes/footer.php');
?>