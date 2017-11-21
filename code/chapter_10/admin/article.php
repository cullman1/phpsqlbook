<?php
require_once '../config.php';
//$userManager->redirectNonAdmin();
$user_list     = $userManager->getAllUsers();
$category_list = $categoryManager->getAllCategories();

// Get data
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values

// article data
$title         = ( isset($_POST['title'])       ? trim(($_POST['title']))       : ''); // Get values
$summary       = ( isset($_POST['summary'])     ? trim(($_POST['summary']))     : ''); // Get values
$content       = ( isset($_POST['content'])     ? trim(($_POST['content']))     : ''); // Get values
$published     = ( isset($_POST['published'])   ? $_POST['published']   : ''); // Get values
$user_id       = ( isset($_POST['user_id'])     ? $_POST['user_id']     : ''); // Get values
$category_id   = ( isset($_POST['category_id']) ? $_POST['category_id'] : ''); // Get values
$article       = new Article($id, $title, $summary, $content, $category_id, $user_id, $published); // Create Article object
  
$errors        = array('title' => '', 'summary'=>'', 'content'=>'', 'published'=>'', 'user_id'=>'', 'category_id'=>'');   // Form errors
$alert         = '';           // Status messages

// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  $article = ($id == '' ? $article : $articleManager->getArticleById($id)); 
  if (!$article) {
    $alert = '<div class="alert alert-danger">Article not found</div>';
    $article       = new Article($id, $title, $summary, $content, $category_id, $user_id, $published); 
    $action= 'create';
  }
} else {
  $errors['title']    = (Validate::isText($title, 1, 64)      ? '' : 'Not a valid title');
  $errors['summary']  = (Validate::IsSafeHTML($summary, 1, 160)   ? '' : 'Not a valid summary');
  $errors['content']  = (Validate::IsSafeHTML($content, 1, 2000)  ? '' : 'Not valid content');
  if (mb_strlen(implode($errors)) > 0) {                                            // If data not valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                                       // Otherwise
    if ($action === 'create') {
      $result  = $articleManager->create($article);      // Add article to database
    }
    if ($action === 'update') {
      $result = $articleManager->update($article);      // Add article to database
    }
  }
  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">' . $action . ' article ' . $article->id .' succeeded</div>';
    $action = 'update';
  }
  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

// Get existing images (has to happen after page has been updated)
if (isset($article->id) && is_numeric($article->id) ) {  // If check passes
  $article_images = $articleManager->getArticleImages($article->id);
}
if (!(isset($article_images)) || sizeof($article_images)<1) {
  $article_images = array();
}

include 'includes/header.php';
?>
<section>
  <h2 class="display-4 mb-4"><?=$action?> article</h2>
  <?= $alert ?>
  <form action="article.php?id=<?=htmlspecialchars($article->id, ENT_QUOTES, 'UTF-8'); ?>&action=<?=htmlspecialchars($action, ENT_QUOTES, 'UTF-8'); ?>" method="post" enctype="multipart/form-data">
    <div class="col-8">
        <div class="form-group">
          <label for="title">Title: </label>
          <input name="title" id="title" value="<?=  htmlentities($article->title) ?>" class="form-control">
          <span class="errors"><?= $errors['title'] ?></span>
        </div>
        <div class="form-group">
          <label for="summary">Summary: </label>
          <textarea name="summary" id="summary" class="form-control"><?=  htmlentities($article->summary, ENT_QUOTES, 'UTF-8') ?></textarea>
          <span class="errors"><?= $errors['summary'] ?></span>
        </div>
        <div class="form-group">
          <label for="content">Content: </label>
          <textarea name="content" id="content" class="form-control"><?=  htmlentities($article->content, ENT_QUOTES, 'UTF-8') ?></textarea>
          <span class="errors"><?= $errors['content'] ?></span>
        </div>

        <div class="form-group">
          <label for="category_id">Category: </label>
          <select name="category_id" id="category_id" class="form-control">
            <?php foreach ($category_list as $category) { ?>
            <option value="<?= $category->id ?>"
              <?php if ($article->category_id == $category->id) {
                echo 'selected';
              }?>
            ><?= $category->name ?></option>
            <?php }?>
          </select>
          <span class="errors"><?= $errors['category_id'] ?></span>
        </div>

        <div class="form-group">
          <label for="user_id">Author: </label>
          <select name="user_id" id="user_id" class="form-control">
            <?php foreach ($user_list as $user) { ?>
            <option value="<?= $user->id ?>"
              <?php if ($article->user_id == $user->id) {
                echo 'selected';
              }?>
            ><?= $user->getFullName(); ?></option>
            <?php }?>
          </select>
          <span class="errors"><?= $errors['user_id'] ?></span>
        </div>

        <div class="form-group">
          <label for="published" class="form-check-label">
            <input type="checkbox" name="published" id="published" value="1" <?php if ($article->published == '1') {echo 'checked';} ?> class="form-check-input">
            Published </label>
        </div>      
    </div><!-- /row -->
    <input type="submit" name="create" value="save" class="btn btn-primary">

  </form>
</section>
<?php include 'includes/footer.php'; ?>