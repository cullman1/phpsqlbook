<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
require_once('includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$name = ( isset($_GET['name']) ? $_GET['name'] : '' );
$name = explode('-',$name);
$forename = $name[0];
$surname = $name[1];
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
include 'templates/header.php'; 
$count = get_article_count_by_author_name($forename,$surname);
$articlelist = get_article_list_by_author_name($forename,$surname, $show, $from);

echo '<h3>Articles by: ' . $forename . ' ' . $surname . '</h3>';
foreach($articlelist as $object) {
    include 'templates/author_list_content.php'; 
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
include 'templates/footer.php'; 
?>