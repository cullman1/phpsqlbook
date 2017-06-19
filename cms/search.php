<?php 
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
require_once('includes/database-connection.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$term = ( isset($_GET['term']) ? $_GET['term'] : '' ); 
$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 5);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);
include 'includes/header.php'; 
$count = get_article_count_by_search($term);
$articlelist = get_articles_by_search($term,$show,$from);
foreach($articlelist as $object) {
    include 'includes/main_content.php'; 
}
if (empty($articlelist)) {
    echo '<span>No articles containing the term "' . $term . '" were found';
}
$pagination = create_pagination($count,$show,$from,$term);
echo $pagination;
include 'includes/footer.php'; 
?>