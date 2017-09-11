<?php
require_once '../classes/config.php';
require_once '../classes/service/Validate.php';

$cms             = new CMS($database_config);
$categoryManager = $cms->getCategoryManager();
$category        = new Category();

$errors          = array('id' => '', 'name'=>'', 'description'=>'');         // Form errors
$alert           = '';                                                       // Status messages

$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$name        = (isset($_POST['name'])        ? $_POST['name']        : '');  // Get values
$description = (isset($_POST['description']) ? $_POST['description'] : '');  // Get values
$update      = isset($_POST['create']);

if (!$update) {
  $category = $categoryManager->getCategoryById($id);
  if (!$category) {
    $alert = '<div class="alert alert-danger">Category not found</div>';
  }
}

if ($update) {
  $errors['id']          = (Validate::isNumber($id, 1, 4060)        ? '' : 'Not a valid id');
  $errors['name']        = (Validate::isText($name, 1, 256)         ? '' : 'Name should be letters A-z and numbers 0-9');
  $errors['description'] = (Validate::isText($description, 1, 1000) ? '' : 'Description should be between 1 and 1000 characters');

  if (strlen(implode($errors)) < 1) {                          // If data valid
    $category = new Category($id, $name, $description);        // Create Category object
    $result   = $categoryManager->update($category);           // Add category to database
  } else {                                                     // Otherwise
    $alert    = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if (isset($result) && ($result === TRUE) ) {                 // Tried to create and it worked
    $alert = '<div class="alert alert-success">Category updated</div>';
  }
  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include 'includes/header.php';
?>

  <h2>Update category</h2>
  <?= $alert ?>

  <form action="category-update.php?id=<?php echo $id ?>" method="post">
    <?php include 'includes/category-form.php'; ?>
    <input type="submit" name="create" value="save" class="btn btn-primary" >
  </form>

<?php include 'includes/footer.php'; ?>