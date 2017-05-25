<?php 
require_once('includes/check-user.php');                         // Is logged in
require_once('../includes/database-connection.php');             // DB connection
require_once('../includes/class-lib.php');                       // Classes
require_once('../includes/functions.php');                       // Functions

$title     = ( isset($_POST['title'] ) ? $_POST['title'] : '');  // Title from form
$alt       = ( isset($_POST['alt'] )   ? $_POST['alt']   : '');  // Alt text from form

$errors    = array('file'=>'', 'title'=>'', 'alt'=>'');          // Form errors
$alert     = '';                                                 // Status messages
$show_form = TRUE;                                               // Show / hide form

function sanitize_file_name($file) {
  $file = preg_replace('([^\w\d\-_~,;.])','',$file);
  $file = preg_replace('([\~,;])', '-', $file);
  return $file;
}

if ( isset($_POST['create']) ) {
  if ( !file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name']) ) {
    $alert = '<div class="alert alert-danger">Upload failed.</div>'; // Error
  } else {
    $filename    = $_FILES['image']['name']; 
    $mediatype   = $_FILES['image']['type']; 
    $temporary   = $_FILES['image']['tmp_name']; 
    $size        = $_FILES['image']['size']; 

    $filename    = sanitize_file_name($filename);
    $directory   = 'uploads';
    $destination = '../' . $directory . '/' . $filename; // Destination is relative directory + filename for admin
    $filepath    = $directory . '/' . $filename;         // Filepath is for the CMS
    $thumb       = '';                                   // Will be added on pXXX

    $Media     = new Media('new', $title, $alt, $mediatype, $filename, $filepath, $thumb);  // Create Media object
    $Validate  = new Validate();             // Create Validation object
    $errors    = $Validate->isMedia($Media); // Validate Category object


    if (file_exists($destination)) {
      $errors['file'] = 'A file of of that name already exists.';
    }

    if (strlen(implode($errors)) < 1) {                       // If data valid
      $moved = move_uploaded_file($temporary, $destination);  // Try to move uploaded file
      $thumb = $Media->createThumbnailGD($filename, $directory, 150, 150); // Create thumbnail
//      $thumb = $Media->createCroppedThumbnail($destination, 150, 150); // Create thumbnail
      $Media->thumb = str_replace($thumb, '../uploads/', 'uploads/');
    } else {                                                  // Otherwise
      $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
    }

    if ( isset($moved) && ($moved === TRUE) ) {        // Tried to create and it worked
      $result = $Media->create();                      // Add category to database
    }
    if ( isset($moved) && ($moved !== TRUE) ) {        // Tried to create and it worked
      $alert = '<div class="alert alert-danger">Could not upload file ' . $filepath . '</div>'; // Error
    }

    if ( isset($result) && ($result === TRUE) ) {      // Tried to create and it worked
      $alert = '<div class="alert alert-success">File saved to ' . $filepath . '</div>';
      $show_form = FALSE;
    }
    if (isset($result) && ($result !== TRUE) ) {       // Tried to create and it failed
      $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }

  }

}

include('includes/admin-header.php'); 
?>

<h2>Add media</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form method="POST" action="" enctype="multipart/form-data">
  <div class="form-group">
    <label for="file">Upload file: </label>
    <input type="file" name="image" accept="image/*" id="file" />
    <span class="errors"><?= $errors['file'] ?></span>
  </div>
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<? $title ?>" id="title" /></label>
    <span class="errors"><?= $errors['title'] ?></span>
  </div>
  <div class="form-group">
    <label for="alt">Alt text:</label>
    <input type="text" name="alt" id="alt" value="<? $alt ?>" /></label>
    <span class="errors"><?= $errors['alt'] ?></span>
  </div>
  <button type="submit" name="create" value="sent">Submit</button>
</form>
<?php 
} else {
  include 'includes/list-media.php';
}
include('includes/admin-footer.php'); 
?>