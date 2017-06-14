<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('../includes/database-connection.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');
$user_id = ( isset($_GET['user_id']) ? $_GET['user_id'] : '' ); 
$article_id = ( isset($_GET['article_id']) ? $_GET['article_id'] : '' ); 
if (remove_like_by_id($user_id, $article_id)) {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>