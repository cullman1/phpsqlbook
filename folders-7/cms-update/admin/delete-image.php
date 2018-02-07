<?php
  require_once '../config.php';

  $image_id = (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? $_GET['id'] : '');
  $article_id = (filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT) ? $_GET['article_id'] : '');
  $page = (filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ? $_GET['page'] : '');
  $allowedToDelete = false;

  if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 2) {
      $allowedToDelete = true;
    } else {
      $allowedToDelete = $cms->userManager->isUserAuthorOfArticle($_SESSION['user_id'], $article_id);
    }
  }

  if (empty($image_id) || empty($article_id)) {
    CMS::redirect('error-has-occurred.php');
  } 
  $result = false;

  if ($allowedToDelete) {
    $result   = $imageManager->deleteImage($image_id);
    if ($result === TRUE) {
      if ($page == "article") {
        CMS::redirect('admin/article.php?include=croppie&action=update&id='. cleanLink($article_id));
      } else {
        CMS::redirect( 'users/user-upload.php?include=croppie&action=update&article_id='. cleanLink($article_id));
      }
    }
  }

include('../includes/header.php'); 
echo "<section class='jumbotron text-center'>";
echo "<div class='container'><h1 class='jumbotron-heading'>We were unable to delete your image.</h1> $result </div>";
echo "</section>";
include('../includes/footer.php');
?>