<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database-connnection.php'); 
require_once('includes/functions.php');
 include 'includes/header.php';
$message = '';
$gallery = init_gallery();                                    // Create gallery object
$gallery->id = ((filter_input(INPUT_GET, 'gallery_id', FILTER_VALIDATE_INT) ? 
$_GET['gallery_id'] : ''));                                   // Gallery id
$action  = ( isset($_GET['action']) ? $_GET['action'] : '' ); // What the user is doing
$galleryids = array();            // Create array for when no items in the gallery
$galleryitems = get_gallery_content($gallery->id);  // Get gallery images
$libraryitems = get_images_list();                  // Get media library
switch ($action) {                // Choose what to do based on action
 case 'add': 
  case 'create':                  // User wants to insert new category
    $gallery->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);    
    $gallery->mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_SPECIAL_CHARS);         
    if (!empty($gallery->name) && !empty($gallery->mode)) {   // Got gallery name & type
      $message = insert_gallery($gallery->name, $gallery->mode); // Can create gallery
    }
    $action  = 'update';        // Set action to update once updated
    break;
  case 'edit':                                          // User wants to edit article
    $gallery = get_gallery_by_id($gallery->id);         // Get gallery detail
    $action  = 'update';                                // Set action to update
    break;
  case 'update':
    if (isset($gallery->id)) {                          // Got a gallery id
      $message = update_gallery($gallery->id, $gallery->name, $gallery->mode); 
    } else {
      $message = '<div class="error">Could not update gallery</div>';
    }
    $libraryitems = get_images_list();                   // Get media library
    break;	
  default:
    header('location: gallery-list.php');
    break;
}
$querystring = '?action=' . $action . '&gallery_id=' . $gallery->id; ?>
<div class="container" role="main">
  <div class="page-header">
   <h2><?=$action;?> gallery</h2>
  </div>
  <?php if ($message != '') { ?>
     <div class="alert alert-info"><?=$message;?></div>
  <?php } ?>
  <form action="<?=$querystring;?>" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
      <label>Name:</label> <input type="text" name="name"  value="<?= htmlspecialchars($gallery->name); ?>" class="form-control" /><br/>
    </div>
    <div class="col-md-6">
      <label>Mode:</label> 
      <select name="mode" class="form-control">
        <option value="0" <?php if ($gallery->mode == 0) { echo 'selected'; } ?> >       
          Thumbnail Gallery</option>
        <option value="1" <?php if ($gallery->mode == 1) { echo 'selected'; } ?> >
          Slider Gallery</option>
        <option value="2" <?php if ($gallery->mode == 2) { echo 'selected'; } ?> >  
          Video</option>
        <option value="3" <?php if ($gallery->mode == 3) { echo 'selected'; } ?> > 
          Audio</option>
      </select>
      <input type="submit" value="save media" class="btn btn-primary" />
    </div>
  </form><br/><br/><br/><br/><br/>
  <?php if (($action == 'create') ||  ($action == 'update')) {       
    foreach ($galleryitems as $galleryitem) { 
      $media = get_media_by_id($galleryitem->media_id);
      $galleryids[] = $galleryitem->media_id; ?>
      <div class="panel panel-default media-thumb">
        <div class="panel-heading">
          <input type="checkbox" checked name="remove" value="<?=$media->id;?>" />
          <span class="filename"><?= $media->filename; ?></span>
        </div>
        <div class="panel-body">
          <?= display_media($media); ?>
        </div>
      </div>
    <?php } 
    foreach ($libraryitems as $libraryitem) {
      $media = get_media_by_id($libraryitem->id); ?>
      <div class="panel panel-default media-thumb">
        <div class="panel-heading">
          <input type="checkbox" name="remove" value="<?=$media->id;?>"
          <?php if (in_array($media->id, $galleryids) ) { echo 'checked'; }?> >
          <span class="filename"><?= $media->filename; ?></span>
        </div>
        <div class="panel-body">
         <?= display_media($media); ?>
        </div>
      </div>
    <?php }
      } // End of check to see if gallery id is present ?>
</div><!-- .container -->
<script>
$('input[type=checkbox]').on('click', function(e) {
  var media_id   = this.value;                             // Media id
  var gallery_id = '<?=$gallery->id?>';                    // Gallery id
  $selected      = $(this);                                // The input that was checked
  $picturebox    = $selected.closest('.panel-default');    // Panel that holds the image
  $gallery       = $('.current-gallery');                  // Current gallery
  $library       = $('.media-library');                    // Media library
  var checked    = $selected.is(":checked");               // Was the element selected
  $.ajax({
    type: "POST",                                          // Use HTTP POST
    url: 'gallery-update.php',                             // To send data to this page
    data: {"gid": gallery_id, "mid": media_id, "chk": checked}, // Data to send
    timeout: 2000,                                         // How long to wait
    beforeSend: function() {                               // Add loading icon
      $selected.next().append('<div class="updating">updating' + checked + '</div>'); 
    },
    complete: function() {                                 // Once Ajax request complete
      $selected.next('.updating').remove();                // Clear loading icon
    },
    success: function(data) {                               // If successful
      if (checked == true) {                                // If checked
        $picturebox.clone(true).appendTo($gallery);         // Clone gallery
        $selected.next().append('<div class="added">added</div>'); // Add success msg
        setTimeout(function() {                             // Set timer to after 2 secs
          $selected.next().find('.added').remove()}, 2000); // Delete success msg
      } else {                                              // Otherwise
        // Remove item from gallery and uncheck the checkbox for the item in the gallery
        $gallery.find('input[value=' + media_id +']').parent().parent().remove(); 
        $library.find('input[value=' + media_id +']').prop('checked', false);
      }
    },
    error: function(data) {                // If there was an error add an error message
      $selected.next().append('<div class="not-added">could not update</div>'); 
      setTimeout(function() {                                // Set timer; after 2 secds
        $selected.next().find('.not-added').remove()}, 2000);// Delete failure msg
      if (checked == true) {                                 // If tried to check
        $library.find('input[value=' + media_id +']').prop('checked', false); // Uncheck
        $gallery.find('input[value=' + media_id +']').prop('checked', false); // Uncheck
      } else {                                               // If tried to uncheck
        $library.find('input[value=' + media_id +']').prop('checked', true);  // Check
        $gallery.find('input[value=' + media_id +']').prop('checked', true);  // Check
      }
    }
  });
});
</script>
<?php include 'includes/footer.php'; ?>