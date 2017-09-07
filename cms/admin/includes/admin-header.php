<?php  $current_page = basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= str_replace('-', ' ', $current_page); ?></title>
</head>
<body>
<div class="container">

<h1>SIMPLE CMS</h1>
<nav class="navbar navbar-default">
  <ul class="nav navbar-nav">
  <li><a href="/phpsqlbook/cms/home">home</a></li>
    <li<?php if (strpos($current_page, 'article') !== false) { echo ' class="active"'; }  ?>><a href="article.php">articles</a></li>
    <li<?php if (strpos($current_page, 'category') !== false) { echo ' class="active"'; }  ?>><a href="category.php">categories</a></li>
    <li<?php if (strpos($current_page, 'user') !== false) { echo ' class="active"'; }  ?>><a href="user.php">users</a></li>
    <li<?php if (strpos($current_page, 'media') !== false) { echo ' class="active"'; }  ?>><a href="media.php">media</a></li>
    <li<?php if (strpos($current_page, 'gallery') !== false) { echo ' class="active"'; }  ?>><a href="gallery.php">galleries</a></li>
        <li><a href="logout.php">logout</a></li> 
  </ul>
</nav>
