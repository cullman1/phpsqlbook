<?php 
session_start();
require_once('includes/class_lib.php');
require_once('includes/functions.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$term = ( isset($_GET['term']) ? $_GET['term'] : '' ); 
getHTMLTemplate('header');
$articlelist = get_articles_by_search(5,0,'','',$term,'');
foreach($articlelist as $object) {
    getHTMLTemplate('main_content',$object);  
}
if (empty($articlelist)) {
    echo '<span>No articles containing the term "' . $term . '" were found';
}
getHTMLTemplate('footer');
?>