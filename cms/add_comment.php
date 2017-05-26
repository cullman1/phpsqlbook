<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/check-user.php');
require_once('includes/class-lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$article_id = (int)(filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT) ? $_GET['article_id'] : '');

$user = get_user_by_id($_SESSION['user_id']);

$comment = new Comment($article_id, $user->id, $user->forename . ' ' . $user->surname, $_POST["comment"], date("Y-m-d H:i:s"));
$comment->add();
   header('Location: '.$_SERVER['HTTP_REFERER']);


?>