<?php 
require_once('includes/check-user.php');                         // Is logged in
require_once('../includes/database-connection.php');             // DB connection
require_once('includes/class-lib.php');                       // Classes
require_once('includes/functions.php');                       // Functions

$id        = ( isset($_GET['id'] )      ? $_GET['id']      : ''); // Title from form
$name      = ( isset($_POST['name'] )   ? $_POST['name']   : ''); // Title from form
$mode      = ( isset($_POST['mode'] )   ? $_POST['mode']   : ''); // Alt text from form
$add       = ( isset($_POST['add'] )    ? $_POST['add']    : ''); // Image to add
$remove    = ( isset($_POST['remove'] ) ? $_POST['remove'] : ''); // Image to remove
$errors    = array('name'=>'', 'mode'=>'');                       // Form errors
$alert     = '';                                                  // Status messages
$show_form = TRUE;                                                // Show / hide form

if (filter_var($add, FILTER_VALIDATE_INT) != FALSE) { // Got a picture to add
  if (insert_gallery_item($add, $id)) { 
    $alert = '<div class="alert alert-success">Image added</div>';
  } else {      
    $alert = '<div class="alert alert-danger">Unable to add image</div>';
  }
}

if (filter_var($remove, FILTER_VALIDATE_INT) != FALSE) { // Got a picture to remove
  if (delete_gallery_item($remove, $id)) { 
    $alert = '<div class="alert alert-success">Image removed</div>';
  } else {      
    $alert = '<div class="alert alert-danger">Unable to remove image</div>';
  }
}

if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) { // Got a number? Create a Gallery object using function
  $Gallery = get_gallery_by_id($id);
}

if ($Gallery) {                                                  // If created
  $Gallery->getGalleryContent();                                 // Get gallery images
} else {
  $alert = '<div class="alert alert-danger">Cannot find gallery</div>'; // Error message
  $show_form = FALSE;                                            // Hide the form
}

if ( isset($_POST['update']) ) {
    $Gallery   = new Gallery($id, $name, $mode);         // Create gallery object
    $Validate  = new Validate();                         // Create Validation object
    $errors    = $Validate->isGallery($Gallery);         // Validate Category object

    if (strlen(implode($errors)) < 1) {                       // If data valid
    	$result = $Gallery->update();
    } else {                                                  // Otherwise
      $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
    }

    if ( isset($result) && ($result === TRUE) ) {      // Tried to create and it worked
      $alert = '<div class="alert alert-success">Gallery updated</div>';
      $show_form = FALSE;
    }
    if (isset($result) && ($result !== TRUE) ) {       // Tried to create and it failed
      $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
}

include('includes/admin-header.php'); 
?>
<h2>Update gallery</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form method="POST" action="?id=<?=$id ?>" id="gallery-update">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?= $Gallery->name ?>" id="name" />
    <span class="errors"><?= $errors['name'] ?></span>
  </div>
  <div class="form-group">
    <label for="mode">Gallery mode:</label>
      <select name="mode" class="form-control" id="mode">
        <option value="0" <?= ($Gallery->mode==0 ? 'selected':'') ?>>Thumbnail</option>
        <option value="1" <?= ($Gallery->mode==1 ? 'selected':'') ?>>Slider</option>
      </select>
    <span class="errors"><?= $errors['mode'] ?></span>
  </div>

  <input type="hidden" name="add" id="add" value="" />
  <input type="hidden" name="remove" id="remove" value="" />

  <div class="panel panel-default">
    <div class="panel-heading" id="gallery-heading">Gallery content</div>
    <div class="panel-body" id="gallery-content">
    <?php 
    if (isset($Gallery->items)) {
      foreach ($Gallery->items as $Media) {
        $Media = get_media_by_id($Media->media_id);
        echo '<a href="#" class="image-remove" data-id="' . $Media->id . '"><img src="' . $Media->thumb . '" alt="' . $Media->alt . '"></a>';
      }
    }
  ?>
  </div>
</div>

<!-- modal opener -->
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#imagesModal" id="featured">add image</button>

  <button type="submit" name="update" value="sent" class="btn btn-primary">save</button>
</form>
<?php 
} else {
  include 'includes/list-galleries.php';
}
  include('includes/image-selector.php'); 
  include('includes/admin-footer.php'); 
?>
<script>
$(function() {
  $(".image-selector").on('click', function (e) {       // User clicks on image in modal
    var media_id = $(this).attr('data-id');             // Get id of image
    $('#add').val(media_id);                            // Store it in hidden form field
    $("#gallery-update").submit();                      // Submit the form
  });

  $("#gallery-content").on('click', 'a', function(e) {  // User clicks on image in panel
    var media_id = $(this).attr('data-id');             // Get id of image
    $('#remove').val(media_id);                         // Store it in hidden form field
    $("#gallery-update").submit();                      // Submit the form
  });
});
</script>