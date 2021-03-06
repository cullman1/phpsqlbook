<?php
  require_once '../config.php';
  $userManager->redirectNonAdmin();

  $action      = (isset($_GET['action'])  ? $_GET['action'] : 'create');
  $id = filter_input(INPUT_GET,'category_id', FILTER_VALIDATE_INT);              
  $name        = (isset($_POST['name'])   ? $_POST['name']        : '');     
  $description = (isset($_POST['description']) ? $_POST['description'] : '');
  $navigation  = (isset($_POST['navigation'])  ? 1  : 0);                    
  $category    = new Category($id, $name, $description, $navigation); 
  $errors      = array('category_id' => '', 'name'=>'', 'description'=>'');    
  $result = $alert       = '';                                                                      
  // Form not submitted
  if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = ($id == '' ? $category : $categoryManager->getCategoryById($id)); 
    if (!$category) {
      header('Location: ../page-not-found.php');
      exit;
    }
  }
  // Form submitted
  if  ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $errors['name']  = (Validate::isName($name, 1, 256) ? '' : 'Can only be A-Z/0-9');
    $errors['description'] = (Validate::isHTML($description, 1, 1000) ? '' : 'Should be  1-1000 characters and only have allowed HTML tags.');
    
    if (strlen(implode($errors)) > 0) {                   // If data not valid
      $alert = '<div class="alert alert-danger">Please correct form errors</div>'; 
    } else {                                                 // Data is valid
      switch($action) {
        case 'create':
           $result = $categoryManager->create($category);    // Add category
           break;
        case 'update' :
           $result = $categoryManager->update($category);    // Update category
           break;
      }
    }

    if  ($result === TRUE)  {            // Tried to create - worked
      $alert = '<div class="alert alert-success">' . $action . ' category worked</div>';
      $action = 'update';
    }
    if  ($result !== TRUE)  {             // Tried to create - failed
      $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
  }
  include 'includes/header.php';
?>
<section>
  <h2><?=Utilities::clean( $action);?> category</h2>
  <?= $alert ?>
  <form method="post" action="?action=<?=Utilities::clean($action) ?>   
        &category_id=<?=Utilities::clean($category->category_id) ?>" >
    <div class="form-group">
    <label for="name">Name: </label>
    <input name="name" value="<?=Utilities::clean( $category->name)?>">
    <span class="errors"><?= $errors['name'] ?></span>
    </div>
    <div class="form-group">
      <label for="description">Description: </label>
      <textarea name="description" id="description" class="form-control">
       <?=  Utilities::clean($category->description); ?>
      </textarea>
      <span class="errors"><?= $errors['description'] ?></span>
    </div>
    <div class="form-group">
      <label for="navigation">Show in navigation: </label>
      <input type="checkbox" name="navigation" id="navigation" value="1"
        <?php if ($category->navigation == 1) { echo 'checked'; } ?> >
    </div>
    <input type="submit" name="submit" value="save" class="btn btn-primary">
  </form>
</section>
<?php include 'includes/footer.php'; ?>