<?php 
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' ); 
getHTMLTemplate('header');

$article = get_article_by_seo_title($title);
getHTMLTemplate('main_content',$article);  
getHTMLTemplate('footer');
?>