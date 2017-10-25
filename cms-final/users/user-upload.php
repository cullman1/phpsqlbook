<?php
require_once '../config.php';

// is logged in otherwise redirect
$userManager->redirectNonAdmin();
$category_list = $categoryManager->getAllCategories();

// Get data
$seo_title   = (isset($_GET['seo_title'])  ? $_GET['seo_title'] : ''); // Get values
$action      = (isset($_GET['action']) ? $_GET['action'] : 'create'); // Get values

// article data
$id            = ( isset($_POST['id'])          ? $_POST['id']          : ''); // Get values
$title         = ( isset($_POST['title'])       ? $_POST['title']       : ''); // Get values
$summary       = ( isset($_POST['summary'])     ? $_POST['summary']     : ''); // Get values
$content       = ( isset($_POST['content'])     ? $_POST['content']     : ''); // Get values
$published     = ( isset($_POST['published'])   ? $_POST['published']   : ''); // Get values
$user_id       = ( isset( $_SESSION['user_id'] )     ?  $_SESSION['user_id']      : ''); // Get values
$category_id   = ( isset($_POST['category_id']) ? $_POST['category_id'] : ''); // Get values
$article       = new Article($id, $title, $summary, $content, $category_id, $user_id, $published); // Create Article object

// image data
$alt           = ( isset($_POST['alt'] )        ? $_POST['alt']         : '');
$media         = new Media('',  $alt, '');              // Create Media object
$errors        = array('title' => '', 'summary'=>'', 'content'=>'', 'published'=>'', 'user_id'=>'', 'category_id'=>'', 'file'=>'',  'alt'=>'');   // Form errors
$alert         = '';           // Status messages
$uploadedfile  = FALSE;        // Was image uploaded


// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing category to edit
  $article = ($seo_title == '' ? $article : $articleManager->getArticleBySeoTitle($seo_title)); // Do you load a category
  if (!$article) {
    $alert = '<div class="alert alert-danger">Article not found</div>';
    //Correct error that if we go back to page it's still in update mode
    $article       = new Article($id, $title, $summary, $content, $category_id, $user_id, $published); // Create Article object
    $action= 'create';
  }
} else {
 if (empty($_POST)) {
    $errors['file'] = 'File too large to upload';
  }
  $errors['title']    = (Validate::isText($title, 1, 64)      ? '' : 'Not a valid title');
  $errors['summary']  = (Validate::isText($summary, 1, 160)   ? '' : 'Not a valid summary');
  $errors['content']  = (Validate::isText($summary, 1, 2000)  ? '' : 'Not valid content');

  $uploadedfile = (file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']) );
  $croppedfile = (isset($_POST['imagebase64'])  ? $_POST['imagebase64'] : '');

  if (($croppedfile) && ($uploadedfile))  {
    $filename    = $_FILES['file']['name'];
    $mediatype   = $_FILES['file']['type'];
    $temporary   = $_FILES['file']['tmp_name'];
    $filesize    = $_FILES['file']['size'];
   $data = $_POST['imagebase64'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);
    $filename = strtolower($filename);
    $filename = str_replace(".jpg",".png", $filename);
    $filename = "cropped_". $filename;
    $filename    = Validate::sanitizeFileName($filename);

    // Validate file information
    $errors['alt']   = (Validate::isText($alt, 1, 256)             ? '' : 'Title should be letters A-z and numbers 0-9');
    $errors['file'] .= (Validate::isAllowedFilename($filename)                ? '' : 'Not a valid filename<br>');
    $errors['file'] .= (Validate::isAllowedExtension($filename)               ? '' : 'Not a valid file extension<br>');
    $errors['file'] .= (Validate::isAllowedMediaType($temporary)              ? '' : 'Not a valid media type<br>');
    $errors['file'] .= (Validate::isWithinFileSize($filesize, 20971520)   ? '' : 'File too large<br>');
    $errors['file'] .= (!file_exists('../uploads/'. $filename)        ? '' : 'A file with that name already exists.');
  }

 if (mb_strlen(implode($errors)) > 0) {                                         // If data not valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                                       // Otherwise
     if ($action === 'create') {
      $result  = $articleManager->create($article);      // Add article to database
    }
    if ($action === 'update') {
      $result = $articleManager->update($article);      // Add article to database
    }
    if ((($croppedfile) && ($uploadedfile)) && isset($result) && ($result === TRUE)) {
       file_put_contents('../uploads/'.$filename, $data);
       $moveresult   = $mediaManager->moveImage($filename, $data);         // Move image
        $media->filename = $filename;
      $saveresult   = $mediaManager->saveImage($article->id, $media);          // Add image to database
      $resizeresult = $mediaManager->resizeImage($filename, 600 );   // Resize image
      $thumbresult  = $mediaManager->resizeImage($filename, 150, TRUE); // Create thumbnail
     
      if ($moveresult != TRUE || $saveresult != TRUE || $resizeresult !=TRUE || $thumbresult != TRUE) {
        $result .= $moveresult .  $saveresult . $resizeresult . $thumbresult; // Add the error to result
      }
    }
  }

  if ( isset($result) && ($result === TRUE) ) {                // Tried to create and it worked
    $alert = '<div class="alert alert-success">' . $action . ' article ' . $article->id .' succeeded</div>';
    $action = 'update';
  }

  if (isset($result) && ($result !== TRUE) ) {                 // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

// Get existing images (has to happen after page has been updated
if (isset($article->id) && is_numeric($article->id) ) {  // If check passes
  $article_images = $articleManager->getArticleImages($article->id);
}
if (!(isset($article_images)) || sizeof($article_images)<1) {
  $article_images = array();
}

include '../includes/header.php';
include '../includes/modal-window.php';
?>
<link href="<?= ROOT ?>lib/croppie/croppie.css" rel="stylesheet" type="text/css">
<script src="<?= ROOT ?>lib/croppie/croppie.js"></script>
<section>
  <h2 class="display-4 mt-4 mb-3"><?=$action?> work</h2>
  <?= $alert ?>

  <form  method="POST" enctype="multipart/form-data" action="<?= ROOT ?>users/user-upload.php?id=<?=htmlspecialchars($article->id, ENT_QUOTES, 'UTF-8'); ?>&action=<?=htmlspecialchars($action, ENT_QUOTES, 'UTF-8'); ?>" >

    <div class="row">
      <div class="col-8">

        <input name="id" value="<?= $article->id ?>" type="hidden">
        <div class="form-group">
          <label for="title">Title: </label>
          <input name="title" id="title" value="<?= $article->title ?>" class="form-control">
          <span class="errors"><?= $errors['title'] ?></span>
        </div>
        <div class="form-group">
          <label for="summary">Summary: </label>
          <textarea name="summary" id="summary" class="form-control"><?= $article->summary ?></textarea>
          <span class="errors"><?= $errors['summary'] ?></span>
        </div>
        <div class="form-group">
          <label for="content">Content: </label>
          <textarea name="content" id="content" class="form-control"><?= $article->content ?></textarea>
          <span class="errors"><?= $errors['content'] ?></span>
        </div>

        <div class="form-group">
          <label for="category_id">Category: </label>
          <select name="category_id" id="category_id" class="form-control">
            <?php foreach ($category_list as $category) { ?>
            <option value="<?= $category->id ?>"
              <?php if ($article->category_id == $category->id) {
                echo 'selected';
              }?>
            ><?= $category->name ?></option>
            <?php }?>
          </select>
          <span class="errors"><?= $errors['category_id'] ?></span>
        </div>

        <input type="hidden" name="user_id" value="<?= $article->user_id ?>">

        <div class="form-group">
          <label for="published" class="form-check-label">
            <input type="checkbox" name="published" id="published" value="1" <?php if ($article->published == '1') {echo 'checked';} ?> class="form-check-input">
            Published </label>
        </div>

      </div>
      <div class="col-4">

        <div class="form-group">
          <label for="file">Upload file: </label>
          <input type="file" name="file" accept="image/*" id="file"  />
                      <input type="hidden" id="imagebase64" name="imagebase64">    
          <span class="errors"><?= $errors['file'] ?></span>
        </div>
        <div class="form-group">
          <label for="alt">Alt text:</label>
          <input type="text" name="alt" id="alt" value="" /></label>
          <span class="errors"><?= $errors['alt'] ?></span>
        </div>

        <?php foreach ($article_images as $image) {
          echo '<img src="' . ROOT . UPLOAD_DIR . 'thumb/' . $image->filename . '" alt="' . htmlentities($image->alt, ENT_QUOTES, 'UTF-8') . '" />
                &nbsp;    <a class="btn btn-primary" href="' . ROOT . 'admin/delete-image.php?id=' . $image->id.'&article_id=' . $article->id.'">Delete Image</a><br><br>';
        } ?>

      </div><!-- /col -->
    </div><!-- /row -->
    <input type="submit" name="create" value="save" class="btn btn-primary">

  </form>
</section>
<?php include '../includes/footer.php'; ?>


<script type="text/javascript">
  $(function() {
    var $uploadCrop;

    function readFile(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $uploadCrop.croppie('bind', { url: e.target.result } );
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $uploadCrop = $('#picture').croppie({
      viewport: { width: 600, height: 360  },
      boundary: { width: 700, height: 400 }
    });

    $('#file').on('change', function () {
      readFile(this);
      $('#imageModal').modal('show');
      $('.photocropper').show();
    });

     $('#btn-close').on('click', function (e) {
       resetFormElement();
     });

    $('.btn-crop').on('click', function (e) {
      e.preventDefault();
      $uploadCrop.croppie('result', {
        enableExif: false,
        enforceBoundary: true,
        type: 'canvas',
        size:  { width: 600, height: 360 }
      }).then(function (croppedimage) {
        $('#imagebase64').val(croppedimage);
      }).then(function() {
        $('#imageModal').modal('toggle');
        $('#crop-success').show();
      });
    });

  });

  function resetFormElement() {
     //This empties the file control if the image isn't cropped and the modal closed.
   $('#file').wrap('<form>').closest('form').get(0).reset();
   $('#file').unwrap();
  }
</script>
<script src="<?=ROOT?>admin/lib/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
  $(function() {
    if ($('#content').length){
      tinymce.init({
        selector: '#content',
        toolbar: 'styleselect, formatselect, bold, italic, alignleft, aligncenter, alignright, alignjustify, bullist, numlist, blockquote',
        plugins: "code"
      });
    }
  });
</script>
