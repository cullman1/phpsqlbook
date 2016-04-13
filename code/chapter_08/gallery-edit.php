<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database-connnection.php'); 
require_once('includes/functions.php'); 

$message = '';

// What should the page be doing?
$gallery = init_gallery();                                               // Create gallery object
$gallery->id = ((filter_input(INPUT_GET, 'gallery_id', FILTER_VALIDATE_INT) ? $_GET['gallery_id'] : ''));  // Gallery id
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' );             // What user is doing
$galleryids = array();            // Create array for when no items in the gallery
switch ($action) {                // Choose what to do based on action
  case 'create':                  // User wants to insert new category
    $gallery->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS); // Get gallery name
    $gallery->mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_SPECIAL_CHARS);   // Get gallery mode
    if ( !empty($gallery->name) && !empty($gallery->mode) ) {    // Got gallery name and type
      $message = insert_gallery($gallery->name, $gallery->mode); // Can create a new gallery
    }
    $action  = 'update';        // Set action to update once updated
    break;
  case 'edit':                                          // User wants to edit article
    $gallery      = get_gallery_by_id($gallery->id);    // Get gallery detail
    $galleryitems = get_gallery_content($gallery->id);  // Get gallery images
    $libraryitems = get_images_list();                  // Get media library
    $action  = 'update';                                // Set action to update
    break;
  case 'update':
    if ( isset($gallery->id) ) {                        // Got a gallery id
      $message = update_gallery($gallery->id, $gallery->name, $gallery->mode); // Update gallery details
    } else {
      $message = '<div class="error">Could not update gallery</div>';
    }
    $gallery      = get_gallery_by_id($gallery->id);     // Get updated gallery detail
    $galleryitems = get_gallery_content($gallery->id);   // Get gallery images
    $libraryitems = get_images_list();                   // Get media library
    break;	
  default:
    header('location: gallery-list.php');
  break;
}
// Update the query string with new action, and current article id if available
$querystring = '?action=' . $action . '&gallery_id=' . $gallery->id;

include 'includes/header.php';
?>


<div class="container" role="main">

  <div class="page-header"><h2><?=$action;?> gallery</h2></div>
  <?php if ($message != '') { ?><div class="alert alert-info"><?=$message;?></div><?php } ?>

  <form action="<?=$querystring;?>" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
      <label>Name:</label> <input type="text" name="name" value="<?= htmlspecialchars($gallery->name); ?>" class="form-control"><br>
    </div>

    <div class="col-md-6">
      <label>Mode:</label> 
      <select name="mode" class="form-control">
        <option value="0" <?php if ($gallery->mode == 0) { echo 'selected'; } ?> >Thumbnail Gallery</option>
        <option value="1" <?php if ($gallery->mode == 1) { echo 'selected'; } ?> >Slider Gallery</option>
        <option value="2" <?php if ($gallery->mode == 2) { echo 'selected'; } ?> >Video</option>
        <option value="3" <?php if ($gallery->mode == 3) { echo 'selected'; } ?> >Audio</option>
      </select>
      <input type="submit" value="save media" class="btn btn-primary">
    </div>
  </form>


  <?php if (($action == 'create') ||  ($action == 'update')) { // Only show media if creating or updating gallery ?>

  <div class="col-md-12 current-gallery">
    <h2>gallery</h2>
    <?php
    foreach ($galleryitems as $galleryitem) { // Would be good if it had file size and dimensions - but code gets v long
      $media = get_media_by_id($galleryitem->media_id);
      $galleryids[] = $galleryitem->media_id;
    ?>
    <div class="panel panel-default media-thumb">
      <div class="panel-heading">
        <input type="checkbox" checked name="remove" value="<?=$media->id;?>">
        <span class="filename"><?= $media->filename; ?></span>
      </div>
      <div class="panel-body">
        <?= display_media($media); ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-12 media-library">
    <h2>all media</h2>
    <?php
    foreach ($libraryitems as $libraryitem) {
      $media = get_media_by_id($libraryitem->id);
    ?>
    <div class="panel panel-default media-thumb">
      <div class="panel-heading">
        <input type="checkbox" name="remove" value="<?=$media->id;?>"
        <?php if (in_array($media->id, $galleryids) ) {
          echo 'checked';
        }?>
        >
        <span class="filename"><?= $media->filename; ?></span>
      </div>
      <div class="panel-body">
       <?= display_media($media); ?>
      </div>
    </div>
    <?php    } ?>
  </div><!-- /.media-library -->
  <?php } // End of check to see if gallery id is present?>
</div><!-- .container -->

<script src="../js/jquery-1.12.0.js"></script>
<script>
// get checkboxes
// when user clicks on checkboxes
// if not selected - add to library
// if selected - remove from library
// change class to indicate doing
// show success / fail

$('input[type=checkbox]').on('click', function(e) {

  var media_id = this.value;                               // URL to load
  var gallery_id = '<?=$gallery->id?>';                    // URL to load

  $selected   = $(this);                                   // The input that was checked
  $picturebox = $selected.closest('.panel-default');       // The panel that holds the image
  $gallery    = $('.current-gallery');                     // Current gallery (left column)
  $library    = $('.media-library');                       // Media library (right column)

  var checked = $selected.is(":checked");                  // Was the element selected

//alert(checked); // true means adding false means removed

  $.ajax({
    type: "POST",                                           // GET or POST
    url: 'gallery-update.php',                              // Path to file
    data: {"gid": gallery_id, "mid": media_id, "chk": checked},     // Data to send
    timeout: 2000,                                          // Waiting time
    beforeSend: function() {                                // Before Ajax 
      $selected.next().append('<div class="updating">updating' + checked + '</div>'); // Load message
    },
    complete: function() {                                  // Once finished
      $selected.next('.updating').remove();                 // Clear message
    },
    success: function(data) {                               // Worked

      $selected.next().find('.updating').remove();          // Clear message
      if (checked == true) {                                // If checked
        $picturebox.clone(true).appendTo($gallery);         // Clone gallery
        $selected.next().append('<div class="added">added</div>'); // Success msg
        setTimeout(function() {                             // Set timer
          $selected.next().find('.added').remove();         // To delete success msg
        }, 2000);                                           // After 2 seconds
      } else {                                              // Otherwise remove
        $gallery.find('input[value=' + media_id +']').parent().parent().remove(); // Remove from gallery
        $library.find('input[value=' + media_id +']').prop('checked', false);     // Uncheck
      }
    },
    error: function(data) {                                 // Show error msg 
      $selected.next().find('.updating').remove();          // Clear updating message
      $selected.next().append('<div class="not-added">could not update</div>'); // Failure msg
      setTimeout(function() {                               // Set timer
        $selected.next().find('.not-added').remove();       // To delete failure msg
      }, 2000);                                             // After 2 seconds
//      alert(JSON.stringify(data));                        // For troubleshooting returned JSON data
      if (checked == true) {                                // If tried to check
        $library.find('input[value=' + media_id +']').prop('checked', false); // Uncheck
        $gallery.find('input[value=' + media_id +']').prop('checked', false); // Uncheck
      } else {                                              // If tried to uncheck
        $library.find('input[value=' + media_id +']').prop('checked', true);  // Check
        $gallery.find('input[value=' + media_id +']').prop('checked', true);  // Check
      }
    }
  });


});

</script>

<?php include 'includes/footer.php'; ?>