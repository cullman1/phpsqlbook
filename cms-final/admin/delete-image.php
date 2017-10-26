<?php
require_once '../config.php';

$image_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$article_id = (filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT) ? $_GET['article_id'] : '');
$page = (filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ? $_GET['page'] : '');

if (empty($image_id) || empty($article_id)) {
    header( "Location: ../error-has-occurred.php" );
    exit();
} 
  $result   = $mediaManager->deleteImage($image_id);
  if ($result === TRUE) {
    if ($page == "article") {
    header('Location: '. ROOT .  'admin/article.php?include=croppie&action=update&id='. htmlentities($article_id, ENT_QUOTES, "UTF-8"));
    exit();
    } else {
    header('Location: '. ROOT .  'users/user-upload.php?include=croppie&action=update&id='. htmlentities($article_id, ENT_QUOTES, "UTF-8"));
    exit();
    }
  }

include('../includes/header.php'); 
echo '<section class="jumbotron text-center">';
echo '<div class="container"><h1 class="jumbotron-heading">We were unable to delete your image.</h1>'.$result ."</div>";
echo '</section>';
include('../includes/footer.php');
?>
<!-- user will have id on their article, check it is on their article, delete image associated with that. //--> 