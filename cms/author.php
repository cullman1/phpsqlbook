<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$name = ( isset($_GET['name']) ? $_GET['name'] : '' );
$name = explode('-',$name);
$forename = $name[0];
$surname = $name[1];
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
get_HTML_template('header');
$wholearticlelist = get_article_list_by_author_name($forename,$surname);
$count = sizeof($wholearticlelist);
$articlelist = get_article_list_by_author_name($forename,$surname, $show, $from);
foreach($articlelist as $object) {
    get_HTML_template('main_content',$object);  
}
$pagination = create_pagination($count,$show,$from);
echo $pagination;
get_HTML_template('footer');
?>