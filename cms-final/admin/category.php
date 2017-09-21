<?php
require_once '../config.php';

$userManager->redirectNonAdmin();

// Get data
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values

$name        = (isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description = (isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$navigation  = (isset($_POST['navigation'])  ? 1  : 0); // Get values
$category    = new Category($id, $name, $description, $navigation);  // Create Category object

$errors      = array('id' => '', 'name'=>'', 'description'=>'');       // Form errors
$alert       = '';                                                     // Status messages

// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing category to edit
  $category = ($id == '' ? $category : $categoryManager->getCategoryById($id)); // Do you load a category
  if (!$category) {
    $alert = '<div class="alert alert-danger">Category not found</div>';
  }
} else {  // The form was posted so validate the data and try to update
  $errors['name']        = (Validate::isText($name, 1, 256)         ? '' : 'Name should be letters A-z and numbers 0-9');
  $errors['description'] = (Validate::isText($description, 1, 1000) ? '' : 'Description should be between 1 and 1000 characters');

  if (strlen(implode($errors)) > 0) {                          // If data valid
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

include 'includes/header.php';
?>

<section>

  <h2><?=$action?> category</h2>
  <?= $alert ?>

  <form action="category.php?id=<?=$category->id?>&action=<?=$action?>" method="post">
    <div class="form-group">
      <label for="name">Name: </label>
      <input name="name" id="name" value="<?= $category->name ?>" class="form-control">
      <span class="errors"><?= $errors['name'] ?></span>
    </div>
    <div class="form-group">
      <label for="description">Description: </label>
      <textarea name="description" id="description" class="form-control"><?= $category->description ?></textarea>
      <span class="errors"><?= $errors['description'] ?></span>
    </div>
    <div class="form-group">
      <label for="navigation">Show in navigation: </label>
      <input type="checkbox" name="navigation" id="navigation" class="form-control" value="1"
          <?php if ($category->navigation == 1) {
            echo 'checked';
          }
          ?>
      >
    </div>
    <input type="submit" name="submit" value="save" class="btn btn-primary">
  </form>

</section>

<?php include 'includes/footer.php'; ?>