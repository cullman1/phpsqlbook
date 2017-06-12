<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/check-user.php');
require_once('includes/class-lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$article_id = (int)(filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT) ? $_GET['article_id'] : '');
$nesting_level = (int)(filter_input(INPUT_GET, 'nesting_level', FILTER_VALIDATE_INT) ? $_GET['nesting_level'] : '');
$reply_to = (string)(filter_input(INPUT_GET, 'replyto', FILTER_SANITIZE_URL) ? $_GET['replyto'] : '');
$toplevelparentid = (string)(filter_input(INPUT_GET, 'toplevelparentid', FILTER_SANITIZE_URL) ? $_GET['toplevelparentid'] : '');
$comment = (string)(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING) ? $_POST["comment"] : '');

$reply_to = str_replace('link','',$reply_to);
$user = get_user_by_id($_SESSION['user_id']);
if (!empty($comment)) {
 $comment = new Comment(0, $article_id, $user->id, $user->forename . ' ' . $user->surname, $user->image, $comment , date("Y-m-d H:i:s"), $toplevelparentid, $nesting_level);
 $comment->add();
}
header('Location: '.$_SERVER['HTTP_REFERER']);


?>