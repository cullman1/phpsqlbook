<?php
require_once '../classes/config.php';
require_once '../classes/service/Validate.php';


$cms             = new CMS($database_config);
$categoryManager = $cms->getCategoryManager();

$name        = ( isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description = ( isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$errors      = array('id' => '', 'name'=>'', 'description'=>'');             // Form errors
$alert       = '';                                                           // Status messages

if (isset($_POST['create'])) {
  $errors['id']          = (Validate::isNumber($id, 1, 4060)        ? '' : 'Not a valid id');
  $errors['name']        = (Validate::isText($name, 1, 256)         ? '' : 'Name should be letters A-z and numbers 0-9');
  $errors['description'] = (Validate::isText($description, 1, 1000) ? '' : 'Description should be between 1 and 1000 characters');

  if (strlen(implode($errors)) < 1) {                          // If data valid
    $category = new Category('', $name, $description);     // Create Category object
    $result = $categoryManager->create($category);             // Add category to database
  } else {                                                     // Otherwise
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">Category added: new id is ' . $category->id . '</div>';
    $show_form = FALSE;
  }

  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include 'includes/header.php';
?>

<h2>Add category</h2>
<?= $alert ?>

<form action="category-create.php" method="post">
  <?php include 'includes/category-form.php'; ?>
</form>

<?php include 'includes/footer.php'; ?>