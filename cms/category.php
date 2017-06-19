<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
require_once('includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' );
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 8);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
include 'templates/header.php';
$count = get_article_count_by_category_name($title);
$articlelist = get_article_list_by_category_name($title, $show, $from);
foreach($articlelist as $object) {
    include 'templates/article_list_content.php';
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
include 'templates/footer.php';
?>