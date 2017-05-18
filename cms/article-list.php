<?php 
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' );
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
getHTMLTemplate('header');
$articlelist = get_articles_by_category($show,$from,'','','','',$title);
foreach($articlelist as $object) {
    getHTMLTemplate('main_content',$object);  
}
getHTMLTemplate('footer');
?>