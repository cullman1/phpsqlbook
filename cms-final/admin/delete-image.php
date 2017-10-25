<?php
require_once '../config.php';

$userManager->redirectNonAdmin();
$image_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
$article_id = (filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT) ? $_GET['article_id'] : '');

if (empty($image_id) || empty($article_id)) {
    header( "Location: ../error-has-occurred.php" );
} else {
  $result   = $mediaManager->deleteImage($image_id);
  if ($result === TRUE) {
    header('Location: '. ROOT .  'admin/article.php?action=update&id='. htmlentities($article_id, ENT_QUOTES, "UTF-8"));
  }
}
include('../includes/header.php'); 
echo '<section class="jumbotron text-center">';
echo '<div class="container"><h1 class="jumbotron-heading">We were unable to delete your image.</h1>'.$result ."</div>";
echo '</section>';
include('../includes/footer.php');
?>
