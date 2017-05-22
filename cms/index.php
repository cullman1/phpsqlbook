<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' );
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);

getHTMLTemplate('header');
$wholearticlelist = get_article_list_by_category_name('All');
$count = sizeof($wholearticlelist);
$articlelist = get_article_list_by_category_name('All', $show,$from);
foreach($articlelist as $object) {
    getHTMLTemplate('main_content',$object);  
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
getHTMLTemplate('footer');
?>