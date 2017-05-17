<?php 
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$title = ( isset($_GET['title']) ? $_GET['title'] : '' ); 
getHTMLTemplate('header');
$articlelist = get_articles_by_category(5,0,'','','','',$title);
foreach($articlelist as $object) {
    getHTMLTemplate('main_content',$object);  
}
getHTMLTemplate('footer');
?>