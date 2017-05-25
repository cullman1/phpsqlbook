<?php 
require_once('includes/check-user.php');                         // Is logged in
require_once('../includes/database-connection.php');             // DB connection
require_once('../includes/class-lib.php');                       // Classes
require_once('../includes/functions.php');                       // Functions

$name      = ( isset($_POST['name'] ) ? $_POST['name'] : '');    // Name of gallery
$mode      = ( isset($_POST['mode'] ) ? $_POST['mode'] : '');    // Type of gallery
$errors    = array('name'=>'', 'mode'=>'');                      // Form errors
$alert     = '';                                                 // Status messages
$show_form = TRUE;                                               // Show / hide form

if ( isset($_POST['create']) ) {
    $Gallery   = new Gallery('new', $name, $mode);  // Create gallery object
    $Validate  = new Validate();             // Create Validation object
    $errors    = $Validate->isGallery($Gallery); // Validate Category object

    if (strlen(implode($errors)) < 1) {                       // If data valid
    	$result = $Gallery->create();
    } else {                                                  // Otherwise
      $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
    }

    if ( isset($result) && ($result === TRUE) ) {      // Tried to create and it worked
      $alert = '<div class="alert alert-success">Gallery created - click edit to add media</div>';
      $show_form = FALSE;
    }
    if (isset($result) && ($result !== TRUE) ) {       // Tried to create and it failed
      $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
}

include('includes/admin-header.php'); 
?>

<h2>Add gallery</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form method="POST" action="">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?= $name ?>" id="name" /></label>
    <span class="errors"><?= $errors['name'] ?></span>
  </div>
  <div class="form-group">
    <label for="mode">Gallery type:</label>
      <label>Mode:</label> 
      <select name="mode" class="form-control" id="mode">
        <option value="0" <?php if ($mode == 0) { echo 'selected'; } ?>>Thumbnail Gallery</option>
        <option value="1" <?php if ($mode == 1) { echo 'selected'; } ?>>Slider Gallery</option>
        <option value="2" <?php if ($mode == 2) { echo 'selected'; } ?>>Video</option>
        <option value="3" <?php if ($mode == 3) { echo 'selected'; } ?>>Audio</option>
      </select>
    <span class="errors"><?= $errors['mode'] ?></span>
  </div>
  <button type="submit" name="create" value="sent">Submit</button>
</form>
<?php 
} else {
  include 'includes/list-galleries.php';
}
include('includes/admin-footer.php'); 
?>