<?php
require_once '../config.php';
$cms->userManager->redirectNonAdmin();
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values
$name        = (isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description = (isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$navigation  = (isset($_POST['navigation'])  ? 1  : 0); // Get values
$category    = new Category($id, $name, $description, $navigation);  // Create Category object
$errors      = array('id' => '', 'name'=>'', 'description'=>'');       // Form errors
                                                  // Status messages
// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing category to edit
  $category = ($id == '' ? $category : $cms->categoryManager->getCategoryById($id)); // Do you load a category
  if (!$category) $cms->redirect('page-not-found.php'); 
} else {  // The form was posted so validate the data and try to update
  $errors['name']        = (Validate::isName($name, 1, 256)         ? '' : 'Name should be letters A-z and numbers 0-9 and contain no HTML tags');
  $errors['description'] = (Validate::isHTML($description, 1, 1000) ? '' : 'Description should be between 1 and 1000 characters and only contain allowed HTML tags.');
  if (strlen(implode($errors)) > 0) {                          // If data valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                     // Otherwise
    if ($action === 'create')       $result = $cms->categoryManager->create($category);             // Add category to database
    if ($action === 'update') $result = $cms->categoryManager->update($category);             // Add category to database
      
   
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">' . $action . ' category ' . $category->category_id .' succeeded</div>';
    $action = 'update';
  }

  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include 'includes/header.php';
?>

<section>

  <h2><?=CMS::clean( $action);?> category</h2>
  <?= $alert ?? '' ?>

  <form action="category.php?id=<?=CMS::cleanLink($category->category_id);?>&action=<?=CMS::cleanLink($action); ?>" method="post">
    <div class="form-group">
      <label for="name">Name: </label>
      <input name="name" id="name" value="<?= CMS::clean( $category->name) ?>" class="form-control">
      <span class="errors"><?= $errors['name'] ?></span>
    </div>
    <div class="form-group">
      <label for="description">Description: </label>
      <textarea name="description" id="description" class="form-control"><?=  CMS::clean($category->description); ?></textarea>
      <span class="errors"><?= $errors['description'] ?></span>
    </div>
    <div class="form-group">
      <label for="navigation">Show in navigation: </label>
      <input type="checkbox" name="navigation" id="navigation" class="form-control" value="1"
          <?php if ($category->navigation == 1) {
            echo 'checked';
          } ?>
    </div>
    <input type="submit" name="submit" value="save" class="btn btn-primary">
  </form>

</section>

<?php include 'includes/footer.php'; ?>