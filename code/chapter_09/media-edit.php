<?php
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';

// What should the page be doing?
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' ); 

// Setup  article object and get values from  form if supplied
$media = init_media(); 

switch ($action) {                // Choose what to do based on action
  case 'add':                     // media wants to add a category
    $action = 'create';           // Set action to insert
	break;

  case 'create':                  // User wants to insert new category
    if( isset($_FILES['image']) ) {
      $image           = $_FILES['image'];
      $media->title    = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS); // Get file title
      $media->alt      = filter_input(INPUT_POST, 'alt', FILTER_SANITIZE_SPECIAL_CHARS);   // Get alt text
      $media->filepath = 'uploads/' . $_FILES['image']['name'];
    }

    if ( !empty($media->title) && !empty($media->alt) ) {
      $message = upload_file($image, $media->title, $media->alt);
    }
    $action  = 'update';        // Set action to update once updated
    break;

  case 'edit':                    // User wants to edit article
    $media = get_media_by_id($media->id);
    $action  = 'update';        // Set action to update
    break;

  case 'update':
    if ( isset($media->id) ) {
      $message = update_media($media->id, $media->title, $media->alt);
    } else {
      $message = '<div class="error">Could not update media</div>';
    }
    $media   = get_media_by_id($media->id);
    break;	

  case 'delete':
    if ( isset($media->id) ) {
      $message = delete_media($media->id);
   	} else {
      $message = '<div class="error">Could not delete media</div>';
   	}
    $action = 'add';
	break;

	default:
		header('location: media-list.php');
  		break;
}
// Update the query string with new action, and current article id if available
$querystring = '?action=' . $action . '&media_id=' . $media->id;

include 'includes/header.php';
?>

<?=$message;?>

<div class="panel">
<h2><?=$action;?> media</h2>
<div class="col-2">
  <form action="<?=$querystring;?>" method="post" enctype="multipart/form-data">
  	<?php if ( $action == 'create' ) { ?>
	<label>Image:</label> <input type="file" name="image" accept="image/*" /><br>
    <?php } ?>
    <label>Title:</label> <input type="text" name="title" value="<?= htmlspecialchars($media->title); ?>"><br>
    <label>Alt:</label> <input type="text" name="alt" value="<?= htmlspecialchars($media->alt); ?>"><br>
    <input type="submit" value="save media" class="button save">
  </form>
</div>
<div class="col-2">
  <?php if ($media->filepath != '') { ?>
    <img src="../<?=$media->filepath?>" alt="<?=$media->alt?>" class="thumb" />
  <?php } ?>
</div>

</div>
<?php include 'includes/footer.php'; ?>