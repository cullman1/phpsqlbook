<?php
require_once '../config.php';
$cms->userManager->redirectNonAdmin();
$user_list     = $cms->userManager->getAllUsers();
$category_list = $cms->categoryManager->getAllCategories();
$id            = filter_input(INPUT_GET,'article_id', FILTER_VALIDATE_INT);
$action        = $_GET['action']        ?? 'create';
$title         = $_POST['title']        ?? '';
$summary       = $_POST['summary']      ?? '';
$content       = $_POST['content']      ?? '';
$published     = $_POST['published']    ?? '';
$user_id       = $_POST['user_id']      ?? '';
$category_id   = $_POST['category_id']  ?? '';
$errors        = array('title' => '', 'summary'=>'', 'content'=>'');
$article       = new Article($id, $title, $summary, $content, $category_id, $user_id,
    $published);

// Form not submitted yet, try to load the requested article
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $article = (empty($id) ? $article : $cms->articleManager->getArticleById($id));
    if (!$article)  $cms->redirect('page-not-found.php');
}
// Form was submitted, try to create or update the article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors['title'] = (Validate::isText($title, 1, 64) ? '' : $error_title);
    $errors['summary'] = (Validate::isText($summary, 1, 160) ? '' : $error_summary);
    $errors['content'] = (Validate::isHTML($content, 1, 2000) ? '' : $error_content);
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
include 'includes/header.php'; ?> 
<section>
  <h2 class="display-4 mb-4"><?=$action ?> article</h2><?= $alert ?? '' ?>
  <form method="post" action="?action=<?= CMS::cleanLink($action) ?>&article_id=<?=CMS::cleanLink($article->article_id) ?>">
    <div class="col-8">
      <div class="form-group">
      <label for="title">Title: </label>
      <input name="title" value="<?=CMS::clean($article->title)?>">
      <span class="error"><?= $errors['name'] ?></span>
    </div>
    <div class="form-group">
    <label for="summary">Summary: </label>
    <textarea name="summary" id="summary" class="form-control"><?=CMS::clean($article->summary) ?></textarea>
    <span class="errors"><?= $errors['summary'] ?></span>  
  </div>
  <div class="form-group">
    <label for="content">Content: </label>
     <textarea name="content" id="content" class="form-control">
     <?= CMS::clean($article->content) ?></textarea>
    <span class="errors"><?= $errors['content'] ?></span>  
  </div>
  <div class="form-group">
    <label for="category_id">Category:  </label> 
      <select name="category_id" id="category_id" class="form-control">
      <?php foreach ($category_list as $category) { ?>
        <option value="<?= $category->category_id ?>"
          <?php if ($article->category_id == $category->category_id) { 
            echo 'selected'; 
            } ?> >
        <?= $category->name ?></option>
      <?php } ?>
      </select>
  </div>
  <div class="form-group">
    <label for="user_id">Author: </label>
      <select name="user_id" id="user_id" class="form-control">
       <?php foreach ($user_list as $user) { ?>
         <option value="<?= $user->user_id ?>" 
           <?php if ($article->user_id == $user->user_id) {  
              echo 'selected'; 
           } ?> ><?= $user->getFullName(); ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="form-check-label">
    <input type="checkbox" name="published" value="1" class="form-check-input"
    <?php if ($article->published == '1') {echo 'checked';} ?>> Published </label>
  </div>
</div>
<input type="submit" name="create" value="save" class="btn btn-primary">
</form>
</section>
<?php include 'includes/footer.php'; ?>