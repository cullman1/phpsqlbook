<?php 
  require_once '../config.php';
  $userManager->redirectNonAdmin();
  $user_list     = $userManager->getAllUsers();   
  $category_list = $categoryManager->getAllCategories();
  $id     = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);      // Get article data
  $action = (isset($_GET['action'])       ? $_GET['action'] : 'create'); 
  $title         = ( isset($_POST['title'])       ? trim(($_POST['title']))       : '');
  $summary       = ( isset($_POST['summary'])     ? trim(($_POST['summary']))     : '');
  $content       = ( isset($_POST['content'])     ? trim(($_POST['content']))     : '');   
  $published     = ( isset($_POST['published'])   ? $_POST['published']           : '');
  $user_id       = ( isset($_POST['user_id'])     ? $_POST['user_id']             : '');   
  $category_id   = ( isset($_POST['category_id']) ? $_POST['category_id']         : ''); 
  $article = new Article($id, $title, $summary, $content, $category_id, $user_id, 
                         $published);   
  $errors        = array('title' => '', 'summary'=>'', 'content'=>''); // Form errors
  $alert         = '';                                                 // Status message
  if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
    $article = ($id == '' ? $article : $articleManager->getArticleById($id)); 
    if (!$article) {
      $alert = '<div class="alert alert-danger">Article not found</div>';
      $article = new Article($id, $title, $summary, $content, $category_id, $user_id,       
                             $published); 
      $action= 'create';
  }
  } else {
  $errors['title'] = (Validate::isText($title, 1, 64)      ? '' : 'Invalid title');
  $errors['summary'] = (Validate::isSafeHTML($summary,1,160) ? '' : 'Invalid summary');
  $errors['content'] = (Validate::isSafeHTML($content,1,2000) ? '' : 'Invalid content');
  if (mb_strlen(implode($errors)) > 0) {                                                  
    $alert = '<div class="alert alert-danger">Please correct form errors</div>';  
 } else {                                                                          
    if ($action === 'create') {
      $result  = $articleManager->create($article);      // Add article to database
    }
    if ($action === 'update') {
      $result = $articleManager->update($article);      // Add article to database
    }
  }
if ( isset($result) && ($result === TRUE) ) {               
    $alert = '<div class="alert alert-success">' . $action . ' article ' . $article->id 
             .' succeeded</div>';
    $action = 'update';
  }
  if (isset($result) && ($result !== TRUE) ) {                 
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}
include 'includes/header.php'; ?><!-- PHP code on subsequent two pages precedes this --> <section>
  <h2 class="display-4 mb-4"><?=$action ?> article</h2>
  <?= $alert ?>
  <form action="?action=<?=htmlentities($action, ENT_QUOTES, 'UTF-8') ?>&id=<?=htmlentities($article->id, ENT_QUOTES, 'UTF-8') ?>" method="post"> 
    <div class="col-8">
     <div class="form-group">
    <label for="title">Title: </label>
    <input name="title" value="<?=htmlentities($article->title)?>" class="form-control">
    <span class="errors"><?= $errors['title'] ?></span>  
  </div>
  <div class="form-group">
    <label for="summary">Summary: </label>
    <textarea name="summary" id="summary" class="form-control">
    <?=htmlentities($article->summary, ENT_QUOTES, 'UTF-8') ?></textarea>
    <span class="errors"><?= $errors['summary'] ?></span>  
  </div>
  <div class="form-group">
    <label for="content">Content: </label>
     <textarea name="content" id="content" class="form-control">
     <?= htmlentities($article->content, ENT_QUOTES, 'UTF-8') ?></textarea>
    <span class="errors"><?= $errors['content'] ?></span>  
  </div>
  <div class="form-group">
    <label for="category_id">Category:  </label> 
      <select name="category_id" id="category_id" class="form-control">
      <?php foreach ($category_list as $category) { ?>
        <option value="<?= $category->id ?>"
        <?php if ($article->category_id == $category->id) { echo 'selected'; }?> >
        <?= $category->name ?></option>
        <?php }?>
      </select>
  </div>
  <div class="form-group">
    <label for="user_id">Author: </label>
      <select name="user_id" id="user_id" class="form-control">
      <?php foreach ($user_list as $user) { ?>
        <option value="<?= $user->id ?>" <?php if ($article->user_id == $user->id) { 
        echo 'selected'; }?> ><?= $user->getFullName(); ?></option>
      <?php }?>
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