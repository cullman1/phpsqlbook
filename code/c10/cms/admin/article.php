<?php
require_once '../config.php';
$cms->userManager->redirectNonAdmin();
$user_list     = $cms->userManager->getAllUsers();
$category_list = $cms->categoryManager->getAllCategories();

$id            = filter_input(INPUT_GET, 'article_id', FILTER_VALIDATE_INT);
$action        = $_GET['action'] ?? 'create';

// Form not submitted yet, try to load the requested article
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $article = (empty($id) ? $article : $cms->articleManager->getArticleById($id));
  if (!$article)  $cms->redirect('page-not-found.php');
}

// Form was submitted, try to create or update the article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title             = $_POST['title']        ?? '';
  $summary           = $_POST['summary']      ?? '';
  $content           = $_POST['content']      ?? '';
  $published         = $_POST['published']    ?? '';
  $category_id       = $_POST['category_id']  ?? '';
  $user_id           = $_POST['user_id']      ?? '';
  $article           = new Article($id, $title, $summary, $content, $category_id, $user_id, $published);

  $errors['title']   = Validate::isArticleTitle($title);
  $errors['summary'] = Validate::isArticleSummary($summary);
  $errors['content'] = Validate::isArticleContent($content);

  if (strlen(implode($errors)) > 0) {
    $alert = "<div class=\"alert alert-danger\">$error_form_correct</div>";
  } else {
    if (strlen(implode($errors)) == 0) {
      if ($action == 'create') $result = $cms->articleManager->create($article); // Create
      if ($action == 'update') $result = $cms->articleManager->update($article); // Update
    }
    if (isset($result) && ($result === TRUE)) {
      $alert = "<div class=\"alert alert-success\">$action $alert_success</div>";
      $action = 'update';
    }
    if (isset($result) && ($result !== TRUE)) {
      $alert = "<div class=\"alert alert-danger\">$error_article_duplicate</div>";
    }
  }
}
include 'includes/header.php';
include 'includes/article-form.php';
include 'includes/footer.php'; ?>