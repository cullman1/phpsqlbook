<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' ); 
get_HTML_template('header');
$article = get_article_by_seo_title($title);
get_HTML_template('main_content',$article);  
get_HTML_template('footer');
?>