<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('includes/class-lib.php');                          // Classes
require_once('includes/functions.php');                          // Classes

$id          = 'new';
$title       = ( isset($_POST['title'])       ? $_POST['title']       : ''); // Get values
$content     = ( isset($_POST['content'])     ? $_POST['content']     : ''); // Get values
$published   = NULL;
$category_id = ( isset($_POST['category_id']) ? $_POST['category_id'] : ''); // Get values
$user_id     = ( isset($_POST['user_id'])     ? $_POST['user_id']     : ''); // Get values
$media_id    = ( isset($_POST['media_id'])    ? $_POST['media_id']    : ''); // Get values
$Article     = new Article($id, $title, $content, $published, $category_id, $user_id, $media_id);       // Create Category object

$errors    = array('title' => '', 'content'=>'', 'published'=>'', 'category_id'=>'', 'user_id'=>'');    // Form errors
$alert     = '';                                                     // Status messages
$show_form = TRUE;                                                   // Show / hide form

if (isset($_POST['create'])) {
  $Validate = new Validate();                                // Create Validation object
  $errors   = $Validate->isArticle($Article);                // Validate Category object
  
  if (strlen(implode($errors)) < 1) {                        // If data valid
    $result = $Article->create();                            // Add category to database
  } else {                                                   // Otherwise
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if (isset($result) && ($result === TRUE)) {                   // Tried to create and it worked
    $alert = '<div class="alert alert-success">Article added</div>';
    $show_form = FALSE;
  }

  if (isset($result) && ($result !== TRUE)) {          // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include('includes/admin-header.php'); 
?>

<h2>Add article</h2>
<?= $alert ?>
<?php if ($show_form == TRUE) { ?>
<form action="article-create.php" method="post" id="form">

  <div class="row">
    <div class="col-md-8">

      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= $Article->title ?>" id="title"><br>
        <span class="error"><?= $errors['title'] ?></span>
      </div>
      <div class="form-group">
        <label for="category_id">Category:</label>
        <?php echo create_category_dropdown($Article->category_id); ?><br>
        <span class="error"><?= $errors['category_id'] ?></span>
      </div>
      <div class="form-group">
       <label for="user_id">Author:</label>
        <?php echo create_user_dropdown($Article->user_id); ?><br>
        <span class="error"><?= $errors['user_id'] ?></span>
      </div>

    </div><!-- /.col-md-8 -->
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Featured image</h3>
        </div>
        <div class="panel-body">
          <input type="hidden" id="media_id" name="media_id" value="<?= $Article->media_id;?>" />
          <img src="" id="featured-image" /><br>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imagesModal">select image</button>
        </div>
      </div>

    </div><!-- /.col-md-4 -->
  </div><!-- /.row -->


       <div class="form-group">
    <label for="content">Content:</label><span class="error"><?= $errors['content'] ?></span>
    <textarea id="editor" name="content" style="width:100%; height: 200px; border: 1px solid #999"><?= $Article->content ?></textarea><br>
  </div>


  <input type="submit" name="create" value="save" class="btn btn-default">
</form>
<?php } else {
  include('includes/list-articles.php'); 
}
  include('includes/image-selector.php'); 
  include('includes/gallery-selector.php'); 
  include('includes/admin-footer.php');?>
<script>
$(function() {

  var update;                               // Where the image is going

  tinymce.init({
    selector: '#editor',
    toolbar: 'styleselect, formatselect, bold, italic, alignleft, aligncenter, alignright, alignjustify, bullist, numlist, blockquote, image',
    plugins: "code",
    setup: function (editor) {
      editor.addButton('image', {
        text: '',
        icon: 'image',
        onclick: function () {
          update = 'editor';
          $('#imagesModal').modal('show');
        }
      });
    },
  });

  $("#featured").on('click', function(){    // If user clicks on featured image button
    update = 'featured';                    // Set variable to featured
  });

  $(".image-selector").on('click', function () {   // User clicks on radio in modal
    var media_id = $(this).attr('data-id');        // Get id of image
    var path     = $(this).attr('data-filepath');  // Get filepath of image
    var alt      = $(this).attr('data-alt');       // Get alt text of image

    if (update == 'editor') {                      // If updating the editor
      var ed = tinyMCE.get('editor');                     // get editor instance
      var range = ed.selection.getRng();                  // get range
      var newNode = ed.getDoc().createElement ( "img" );  // create img node
      newNode.src= path;                           // add src attribute
      newNode.alt=alt;                           // add src attribute
      range.insertNode(newNode);
    }

    if (update == 'featured') {
      var $featuredImage = $("#featured-image");
      var control = $("#media_id");                        // Hidden form control
      $featuredImage.attr('src',  path);
      $featuredImage.attr('alt', alt);
      control.val(media_id);                               // Update hidden form control
    }

    $('#imagesModal').modal('hide');
  });

  $(".gallery-selector").on('click', function () {   // User clicks on radio in modal
    var gallery_id = $(this).attr('data-id');        // Get id of image
    var path       = $(this).attr('data-filepath');  // Get filepath of image
    var alt        = $(this).attr('data-alt');       // Get alt text of image
    var $galleryImage = $("#gallery-image");
    var control = $("#gallery_id");                  // Hidden form control
      $galleryImage.attr('src',  path);
      $galleryImage.attr('alt', alt);
      control.val(gallery_id);                       // Update hidden form control
    $('#galleriesModal').modal('hide');
  });

});
</script>