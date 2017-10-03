<?php
require_once 'config.php';

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
  // No - show a blank category to create or an existing category to edit
  $article = ($seo_title == '' ? $article : $articleManager->getArticleBySeoTitle($seo_title)); // Do you load a category
  if (!$article) {
    $alert = '<div class="alert alert-danger">Article not found</div>';
  }
} else {
  $errors['title']    = (Validate::isText($title, 1, 64)      ? '' : 'Not a valid title');
  $errors['summary']  = (Validate::isText($summary, 1, 160)   ? '' : 'Not a valid summary');
  $errors['content']  = (Validate::isText($summary, 1, 2000)  ? '' : 'Not valid content');

  $uploadedfile = (file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']) );
  if ($uploadedfile) {
    $filename    = $_FILES['file']['name'];
    $mediatype   = $_FILES['file']['type'];
    $temporary   = $_FILES['file']['tmp_name'];
    $filesize    = $_FILES['file']['size'];

    $filename    = Validate::sanitizeFileName($filename);
    $media->filename = $filename;

    // Validate file information
    $errors['imagetitle'] = (Validate::isText($imagetitle, 1, 256) ? '' : 'Title should be letters A-z and numbers 0-9');
    $errors['alt']   = (Validate::isText($alt, 1, 256)             ? '' : 'Title should be letters A-z and numbers 0-9');
    $errors['file'] .= (Validate::isAllowedFilename($filename)                ? '' : 'Not a valid filename<br>');
    $errors['file'] .= (Validate::isAllowedExtension($filename)               ? '' : 'Not a valid file extension<br>');
    $errors['file'] .= (Validate::isAllowedMediaType($mediatype)              ? '' : 'Not a valid media type<br>');
    $errors['file'] .= (Validate::isWithinFileSize($filesize, 1000000)   ? '' : 'File too large<br>');
    $errors['file'] .= (!file_exists('../uploads/'. $filename)        ? '' : 'A file with that name already exists.');
  }

  if (strlen(implode($errors)) > 0) {                                            // If data not valid
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  } else {                                                                       // Otherwise
    if ($action === 'create') {
      $result  = $articleManager->create($article);      // Add article to database
      if ($uploadedfile) {
        $moveresult  = $mediaManager->moveImage($filename, $temporary);         // Move image
        $imageresult = $mediaManager->saveImage($article->id, $media);       // Add image to database
        $thumbresult = $mediaManager->createThumbnailGD($filename, 150, 150); // Create thumbnail
        if ($moveresult != TRUE || $imageresult !=TRUE || $thumbresult != TRUE) {
          $result .= $moveresult .  $imageresult . $thumbresult; // Add the error to result
        }
      }
    }
    if ($action === 'update') {
      $result  = $articleManager->update($article);      // Add article to database
      if ($uploadedfile) {
        $moveresult  = $mediaManager->moveImage($filename, $temporary);         // Move image
        $imageresult = $mediaManager->saveImage($article->id, $media);       // Add image to database
        $thumbresult = $mediaManager->createThumbnailGD($filename, 150, 150); // Create thumbnail
        if ($moveresult != TRUE || $imageresult !=TRUE || $thumbresult != TRUE) {
          $result .= $moveresult .  $imageresult . $thumbresult; // Add the error to result
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
<section>
  <h2 class="display-4 mt-4 mb-3"><?=$action?> work</h2>
  <?= $alert ?>

  <form action="<?=ROOT?>users/<?=$action?>/<?=$seo_title?>" method="post" enctype="multipart/form-data">

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
          <span class="errors"><?= $errors['file'] ?></span>
        </div>
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
          echo '<img src="' . ROOT . UPLOAD_DIR . 'thumb/' . $image->filename . '" alt="' . $image->alt . '" /><br><br>';
        } ?>

      </div><!-- /col -->
    </div><!-- /row -->
    <input type="submit" name="create" value="save" class="btn btn-primary">

  </form>
</section>
<?php include 'includes/footer.php'; ?>
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