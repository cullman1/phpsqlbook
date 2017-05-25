<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' );
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);

get_HTML_template('header');
$count = get_article_count();
$articlelist = get_article_list($show,$from);
foreach($articlelist as $object) {
    get_HTML_template('main_content',$object);  
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
get_HTML_template('footer');
?>