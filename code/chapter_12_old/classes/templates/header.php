<?php
require_once('../includes/functions.php'); 
 $db = $this->registry->get('database'); 

$current_article  = (filter_input(INPUT_GET, 'article_id',  FILTER_VALIDATE_INT) ? $_GET['article_id']  : 0); 
$current_category = (filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) ? $_GET['category_id'] : 0);
$pagetype = "";
switch ($pagetype) {
  case 'article':
    if ($current_article > 0) {
      $article = $db->get_article_user_category_and_thumb_by_id($current_article);
      $current_category = $article->category_id;
    } else {
      header('Location: 404.php');
    }
    break;

  case 'category':
    if ($current_category > 0) {
      $article_list  = $db->get_articles_by_category($current_category); 
      $category      = $db->get_category_by_id($current_category);
      $category_name = $category->name;
    } else {
      header('Location: 404.php');
    }
    break;

   default:
      break;
}
$category_list =  getCategoryListArray($db->connection); 
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>   
  <link rel="stylesheet" type="text/css" href="/phpsqlbook/cms/css/styles.css" />
  <link href='https://fonts.googleapis.com/css?family=Caudex:400,700|Gilda+Display' rel='stylesheet' type='text/css'>
  </head>
<body>
  <header>
    <h1>the green room</h1>
     <nav>
      <a href="\phpsqlbook\Home">Home</a>