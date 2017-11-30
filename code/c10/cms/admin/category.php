<?php
  require_once '../config.php';

  $userManager->redirectNonAdmin();

  $action      = (isset($_GET['action'])  ? $_GET['action'] : 'create');
  $id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);              
  $name        = (isset($_POST['name'])   ? $_POST['name']        : '');     
  $description = (isset($_POST['description']) ? $_POST['description'] : '');
  $navigation  = (isset($_POST['navigation'])  ? 1  : 0);                    
  $category    = new Category($id, $name, $description, $navigation); // Create Category 
  $errors      = array('id' => '', 'name'=>'', 'description'=>'');    // Form errors
  $alert       = '';                                                  // Status message
  if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {                    // Was form posted
    $category = ($id == '' ? $category : $categoryManager->getCategoryById($id)); 
    if (!$category) {
      $alert = '<div class="alert alert-danger">Category not found</div>';
      $category  = new Category($id, $name, $description, $navigation);//Create Category
      $action = 'create';
    }
  } else {  // The form was posted so validate the data and try to update
    $errors['name']  = (Validate::isName($name, 1, 256) ? '' : 
    'Name can only be A-Z/0-9');
    $errors['description'] = (Validate::isSafeHTML($description, 1, 1000) ? '' :  
    'Description should be between 1-1000 characters and only have allowed HTML tags.');
    if (mb_strlen(implode($errors)) > 0) {                   // If data not valid
      $alert = '<div class="alert alert-danger">Please correct form errors</div>'; 
    } else {                                                 // Otherwise
      if ($action === 'create') {
        $result = $categoryManager->create($category);       // Add category to database
      }
      if ($action === 'update') {
        $result = $categoryManager->update($category);       // Add category to database
      }
    }
    if ( isset($result) && ($result === TRUE) ) {            // Tried to create - worked
      $alert = '<div class="alert alert-success">' . $action . ' category ' . 
                $category->id .' succeeded</div>';
      $action = 'update';
    }
    if (isset($result) && ($result !== TRUE) ) {             // Tried to create - failed
      $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
  }
  include 'includes/header.php';
?>
<section>
  <h2><?=htmlentities( $action, ENT_QUOTES, 'UTF-8');?> category</h2>
  <?= $alert ?>
  <form action="?action=<?=htmlentities($action, ENT_QUOTES, 'UTF-8') ?>   
        &id=<?=htmlentities($category->id, ENT_QUOTES, 'UTF-8') ?>" method="post">
    <div class="form-group">
    <label for="name">Name: </label>
    <input name="name" value="<?=htmlentities( $category->name, ENT_QUOTES, 'UTF-8')?>">
    <span class="errors"><?= $errors['name'] ?></span>
    </div>
    <div class="form-group">
      <label for="description">Description: </label>
      <textarea name="description" id="description" class="form-control">
       <?=  htmlentities($category->description, ENT_QUOTES, 'UTF-8'); ?>
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