<?php 
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
require_once('includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$name = ( isset($_GET['name']) ? $_GET['name'] : '' );
$name = explode('-',$name);
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
include 'includes/header.php'; 
$count = get_article_count_by_author_name($name[0],$name[1]);
$articlelist = get_article_list_by_author_name($name[0],$name[1], $show, $from);
echo '<h3>Articles by: ' . $name[0] . ' ' . $name[1] . '</h3>';
foreach($articlelist as $object) {
    include 'includes/author_list_content.php'; 
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
include 'includes/footer.php'; 
?>