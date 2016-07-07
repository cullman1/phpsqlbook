<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database_connection.php'); 
require_once('includes/functions.php'); 
$message = '';

// What should the page be doing?
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' ); 

// Setup  article object and get values from  form if supplied
$article = init_article(); 

switch ($action) {                  // Choose what to do based on action
	case 'add':                     // User wants to add an article
		$action = 'create';         // Set action to insert
		break;

	case 'create':                  // User wants to insert new article
		$message = insert_article($article->title, $article->content, $article->category_id, $article->user_id, $article->media_id);
		$action  = 'update';        // Set action to update once updated
		break;

	case 'edit':                    // User wants to edit article
		$article = get_article_user_category_and_thumb_by_id($article->id);
		$action  = 'update';        // Set action to update
		break;

	case 'update':
	    if ( isset($article->id) ) {
	      $message = update_article($article->id, $article->title, $article->content, $article->category_id, $article->user_id, $article->media_id);
	    } else {
	      $message = '<div class="error">Could not update article</div>';
	    }
		$article   = get_article_user_category_and_thumb_by_id($article->id);
    	break;	

	case 'delete':
    	if ( isset($article->id) ) {
    	  $message = delete_article($article->id);
    	} else {
    	  $message = '<div class="error">Could not delete article</div>';
    	}
        $action = 'add';
	    break;

	default:
		header('location: article-list.php');
		break;
}

// Create the category and author drop down select boxes
$category_selector = get_category_selectbox($article->category_id); 
$author_selector   = get_author_selectbox($article->user_id); 
// Get all images for the thumb selector
$images = get_images_list();


// Update the query string with new action, and current article id if available
$querystring = "?action=" . $action . '&article_id=' . $article->id;

include 'includes/header.php';
?>

<?=$message;?>
<div class="panel">

<h2><?=$action;?> article</h2>
<div class="col-2">
  <form action="<?=$querystring;?>" method="post">
    <label>Title:</label> <input type="text" name="title" value="<?= htmlspecialchars($article->title); ?>"><br>
    <label>Published: <?= isset($article->date_published) ? $article->date_published : "Not published"  ?></label><br>
    <label>Category:</label> <?= $category_selector;?><br>
    <label>Author: </label> <?= $author_selector;?><br>
    <label>Content:</label> <textarea name="content" class="contentbox"><?= htmlspecialchars($article->content); ?></textarea><br>
    <input type="hidden" id="media_id" name="media_id" value="<?= $article->featured_media_id;?>" />
    <input type="submit" value="save article" class="button save">
</form>
</div>
    <?php if (isset ($article->file_path)) { ?>
<div class="col-2">
  <label>Featured image: 
  <img src="../<?= $article->file_path;?>" alt="<?= $article->alt_text;?>" id="featured-image" /><br>
  <a class="button" id="opener">update image</a><br>
</div>
    <?php } ?>

</div>

<div class="gallery" id="gallery">
  <h3>Media Gallery</h3>
  <?php 
    if (isset($images)) {                                     // If you have images
    foreach ($images as $image) {                             // Loop through them ?>
    <div class="media-thumb"><br>
      <input type="radio" name="featured" value="<?= $image->id; ?>" data-filepath="<?=$image->file_path;?>"
             <?php if (isset($article->featured_media_id)) { if ($image->id == $article->featured_media_id) { echo 'checked'; } }?> class="image" />
             <?= $image->media_title; ?>&nbsp;
      <img width=50 src="<?= $image->file_path ?>" alt="<?= $image->alt_text ?>" 
           title="<?= $image->media_title ?>" /><br>
    </div>
    <?php 
      }  // End if
    } // End loop code block
    ?>
</div>

<script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="../js/modal.js"></script>
<?php include 'includes/footer.php'; ?>