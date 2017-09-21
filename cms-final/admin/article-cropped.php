<?php
require_once '../config.php';

$userManager->redirectNonAdmin();

$user_list     = $userManager->getAllUsers();
$category_list = $categoryManager->getAllCategories();

// Get data
$id          = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Get values
$action      = (isset($_GET['action'])       ? $_GET['action'] : 'create'); // Get values

// article data
$title         = ( isset($_POST['title'])       ? $_POST['title']       : ''); // Get values
$summary       = ( isset($_POST['summary'])     ? $_POST['summary']     : ''); // Get values
$content       = ( isset($_POST['content'])     ? $_POST['content']     : ''); // Get values
$published     = ( isset($_POST['published'])   ? $_POST['published']   : ''); // Get values
$user_id       = ( isset($_POST['user_id'])     ? $_POST['user_id']     : ''); // Get values
$category_id   = ( isset($_POST['category_id']) ? $_POST['category_id'] : ''); // Get values
$article       = new Article($id, $title, $summary, $content, $category_id, $user_id, $published); // Create Article object

// image data
$imagetitle    = ( isset($_POST['imagetitle'] ) ? $_POST['imagetitle']  : '');
$alt           = ( isset($_POST['alt'] )        ? $_POST['alt']         : '');
$media         = new Media('', $imagetitle, $alt, '');              // Create Media object

$errors        = array('title' => '', 'summary'=>'', 'content'=>'', 'published'=>'', 'user_id'=>'', 'category_id'=>'', 'file'=>'', 'imagetitle'=>'', 'alt'=>'');   // Form errors
$alert         = '';           // Status messages
$uploadedfile  = FALSE;        // Was image uploaded


// Was form posted
if ( !($_SERVER['REQUEST_METHOD'] == 'POST') ) {
  // No - show a blank category to create or an existing article to edit
  $article = ($id == '' ? $article : $articleManager->getArticleById($id)); // Do you load a category
  if (!$article) {
    $alert = '<div class="alert alert-danger">Article not found</div>';
  }
} else {
  $errors['title']    = (Validate::isText($title, 1, 64)      ? '' : 'Not a valid title');
  $errors['summary']  = (Validate::isText($summary, 1, 160)   ? '' : 'Not a valid summary');
  $errors['content']  = (Validate::isText($summary, 1, 2000)  ? '' : 'Not valid content');

  $uploadedfile = (isset($_POST['imagebase64']));
  if ($uploadedfile) {
    $filename    = Validate::sanitizeFileName($title);

    $data = $_POST['imagebase64'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    $media->filename = $filename . '.jpg';

    // Validate file information
    $errors['imagetitle'] = (Validate::isText($imagetitle, 1, 256) ? '' : 'Title should be letters A-z and numbers 0-9');
    $errors['alt']   = (Validate::isText($alt, 1, 256)             ? '' : 'Title should be letters A-z and numbers 0-9');
    $errors['file'] .= (!file_exists('../uploads/'. $filename)        ? '' : 'A file with that name already exists.');
  }

  if (strlen(implode($errors)) > 0) {                                            // If data not valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                                       // Otherwise
    if ($action === 'create') {
      $result  = $articleManager->create($article);      // Add article to database
      if ($uploadedfile) {
        $filename = $filename. '.jpg';
        file_put_contents('../uploads/' . $filename, $data);
        $imageresult = $mediaManager->saveImage($article->id, $media);       // Add image to database
        $thumbresult = $mediaManager->createThumbnailGD($filename, 150, 150); // Create thumbnail
//        $mediaManager->cropImageIM($filename, '../' . UPLOAD_DIR, 150, 150);
        if ($imageresult !=TRUE || $thumbresult != TRUE) {
          $result .= $imageresult . $thumbresult; // Add the error to result
        }
      }
    }
    if ($action === 'update') {
      $result  = $articleManager->update($article);      // Add article to database
      if ($uploadedfile) {
        file_put_contents($filename. '.jpg', $data);
        $imageresult = $mediaManager->saveImage($article->id, $media);       // Add image to database
        $thumbresult = $mediaManager->createThumbnailGD($filename, 150, 150); // Create thumbnail
//        $mediaManager->cropImageIM($filename, '../' . UPLOAD_DIR, 150, 150);
        if ($imageresult !=TRUE || $thumbresult != TRUE) {
          $result .= $imageresult . $thumbresult; // Add the error to result
        }
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

include 'includes/header.php';
?>
<link href="../lib/croppie/croppie.css" rel="stylesheet" type="text/css">
<script src="../lib/jquery/jquery-1.12.4.min.js"></script>
<script src="../lib/croppie/croppie.js"></script>
<section>
  <h2 class="display-4 mb-4"><?=$action?> article</h2>
  <?= $alert ?>

  <form action="article-cropped.php?id=<?=$article->id?>&action=<?=$action?>" method="post" enctype="multipart/form-data">

    <div class="row">
      <div class="col-8">

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

        <div class="form-group">
          <label for="user_id">Author: </label>
          <select name="user_id" id="user_id" class="form-control">
            <?php foreach ($user_list as $user) { ?>
            <option value="<?= $user->id ?>"
              <?php if ($article->user_id == $user->id) {
                echo 'selected';
              }?>
            ><?= $user->getFullName(); ?></option>
            <?php }?>
          </select>
          <span class="errors"><?= $errors['user_id'] ?></span>
        </div>

        <div class="form-group">
          <label for="published" class="form-check-label">
            <input type="checkbox" name="published" id="published" value="1" <?php if ($article->published == '1') {echo 'checked';} ?> class="form-check-input">
            Published </label>
        </div>

      </div>
      <div class="col-8">

        <div class="form-group">
          <label for="file">Upload file: </label>
          <input type="file" accept="image/*" id="file"  />
          <input type="hidden" id="imagebase64" name="imagebase64">
          <span class="errors"><?= $errors['file'] ?></span>
        </div>
        <div class="photocropper" style="display:none">
          <div id="picture"></div>
        </div>

        <a href="#" class="btn-crop btn btn-primary">Crop image</a>

        <div id="crop-success" class="alert alert-success" style="display:none">image cropped</div>

        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" name="imagetitle" value="<?= $imagetitle ?>" id="title" /></label>
          <span class="errors"><?= $errors['imagetitle'] ?></span>
        </div>
        <div class="form-group">
          <label for="alt">Alt text:</label>
          <input type="text" name="alt" id="alt" value="<?= $alt ?>" /></label>
          <span class="errors"><?= $errors['alt'] ?></span>
        </div>

        <?php foreach ($article_images as $image) {
          echo '<img src="../' . UPLOAD_DIR . 'thumb/' . $image->filename . '" alt="' . $image->alt . '" /><br><br>';
        } ?>

      </div><!-- /col -->
    </div><!-- /row -->
    <input type="submit" name="create" value="save" class="btn btn-primary">

  </form>
</section>
<?php include 'includes/footer.php'; ?>
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
      $('.photocropper').show();
    });

    $('.btn-crop').on('click', function (e) {
      e.preventDefault();
      $uploadCrop.croppie('result', {
        type: 'canvas',
        size:  { width: 600, height: 360 }
      }).then(function (croppedimage) {
        $('#imagebase64').val(croppedimage);
      }).then(function() {
        $('#crop-success').show();
      });
    });

  });
</script>
