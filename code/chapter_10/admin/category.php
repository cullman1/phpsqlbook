<?php
require_once '../config.php';
//$userManager->redirectNonAdmin();
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values
$name        = (isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description = (isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$navigation  = (isset($_POST['navigation'])  ? 1  : 0); // Get values
$category    = new Category($id, $name, $description, $navigation);  // Create Category object

$errors      = array('id' => '', 'name'=>'', 'description'=>'');       // Form errors
$alert       = '';                                                     // Status messages
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) { // Was form posted
  $category = ($id == '' ? $category : $categoryManager->getCategoryById($id)); // Do you load a category
  if (!$category) {
    $alert = '<div class="alert alert-danger">Category not found</div>';
    $category    = new Category($id, $name, $description, $navigation);  // Create Category object
    $action = 'create';
  }
} else {  // The form was posted so validate the data and try to update
  $errors['name']        = (Validate::isName($name, 1, 256)         ? '' : 'Name should be letters A-z and numbers 0-9 and contain no HTML tags');
  $errors['description'] = (Validate::isAllowedHTML($description, 1, 1000) ? '' : 'Description should be between 1 and 1000 characters and only contain allowed HTML tags.');
  if (mb_strlen(implode($errors)) > 0) {                          // If data not valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                     // Otherwise
    if ($action === 'create') {
      $result = $categoryManager->create($category);             // Add category to database
    }
    if ($action === 'update') {
      $result = $categoryManager->update($category);             // Add category to database
    }
  }
  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">' . $action . ' category ' . $category->id .' succeeded</div>';
    $action = 'update';
  }
  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}
include '../includes/header.php';
?>
<section>
  <h2><?=htmlentities( $action,ENT_QUOTES,'UTF-8');?> category</h2>
  <?= $alert ?>
  <form action="category.php?id=<?=htmlspecialchars($category->id,ENT_QUOTES,'UTF-8');?>&action=<?=htmlspecialchars($action,ENT_QUOTES,'UTF-8'); ?>" method="post">
    <div class="form-group">
       <label>Name: 
      <input name="name" id="name" style="width:600px;" value="<?= htmlentities( $category->name, ENT_QUOTES, 'UTF-8') ?>" class="form-control"> </label>
      <span class="errors"><?= $errors['name'] ?></span></label>
    </div>
    <div class="form-group">
      <label> Description: <textarea  style="width:600px;" name="description" id="description" class="form-control"><?=  htmlentities($category->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
      <span class="errors"><?= $errors['description'] ?></span></label>
    </div>
    <div class="form-group">
      <label>Show in navigation: <input type="checkbox" name="navigation" id="navigation" class="form-cotrol" value="1"
          <?php if ($category->navigation == 1) { echo 'checked'; } ?> > </label>
    </div>
    <input type="submit" name="submit" value="save" class="btn btn-primary">
  </form>
</section>
<?php include '../includes/footer.php'; ?>