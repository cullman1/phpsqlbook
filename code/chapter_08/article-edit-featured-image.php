<?php
require_once('includes/database-connnection.php'); 
require_once('../CMS/admin/includes/functions.php'); 
$message = '';

// What should the page be doing?
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' ); 

// Setup  article object and get values from  form if supplied
$article = init_article(); 
$images = get_images_list();

switch ($action) {              // Choose what to do based on action
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
	default:
		header('location: index.php');
		break;
}

// Create the category and author drop down select boxes
$category_selector = get_category_selectbox($article->category_id); 
$author_selector   = get_author_selectbox($article->user_id); 

// Update the query string with new action, and current article id if available
$querystring = "?action=" . $action . '&article_id=' . $article->id;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- this file uses Twitter Bootstrap to create the modal window, so thee HTML follows their templates-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CMS/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.min.css">
    <link re="stylesheet" href="chapter.css" /><!-- this one needs to be added - in header.php at the moment -->
    <title>Edit article</title>
  </head>
<body>
<div class="container" role="main">

  <div class="page-header"><h2><?=$action;?> article</h2></div>
  <?php if ($message != '') { ?><div class="alert alert-info"><?=$message;?></div><?php } ?>


  <form action="<?=$querystring;?>" method="post" class="wysiwyg-form">

    <div class="col-md-6">
      <label>Title:</label> <input type="text" name="title" value="<?= htmlspecialchars($article->title); ?>" class="form-control"><br>
      <label>Category:</label> <?= $category_selector;?><br>
      <label>Author: </label> <?= $author_selector;?><br>
      <label>Published:</label>  <?php echo convert_date($article->published) ?><br>
    </div>

    <div class="col-md-6">
      <label>Featured image:</label>
      <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#imagesModal" id="featured"> <i class="icon-picture"></i> select</a> <br>
      <div class="panel panel-default">
        <div class="panel-heading" id="featured-image-title">
          <?= $article->alt;?>
        </div>
        <div class="panel-body" style="overflow:auto;">
          <img src="../<?= $article->filepath;?>" alt="<?= $article->alt;?>" id="featured-image" 
          <?php if ($article->filepath == '') {
            echo 'class="hidden"';
          } ?> /><br>
        </div>
      </div>      
      <input type="hidden" id="media_id" name="media_id" value="<?= $article->media_id; ?>" />
    </div><!-- .col2 -->

    <div class="col-md-12">
      <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
        <div class="btn-group">
          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
            <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
            <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
          <a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
          <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
          <a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
          <a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
          <a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i> <span class="caret"></span></a>
          <div class="dropdown-menu input-append">
            <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
            <button class="btn  btn-default" type="button">Add</button> &nbsp; 
            <a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink">Remove</a>
          </div>
        </div>

        <a class="btn btn-default" data-toggle="modal" data-target="#imagesModal" class="btn" id="inline"> <i class="icon-picture"></i> insert</a>
      </div>
      <div id="editor" name="content"><?= $article->content ?></div>
      <textarea id="textarea" name="content"></textarea>

      <input type="submit" value="save article" class="btn btn-primary">

    </div><!-- .col-md-12 -->

  </form>

</div><!-- .container -->

<?php include('includes/image-gallery.php'); ?>

<script src="../CMS/js/jquery-1.12.0.js"></script>
<script src="../CMS/js/bootstrap.min.js"></script>
<script src="../CMS/js/jquery.hotkeys.js"></script>
<script src="../CMS/js/bootstrap-wysiwyg.js"></script>

<script>
$(function() {
  // Create editor
  $('#editor').wysiwyg();

  // When the form is submitted move content from editor to textarea
  $('.wysiwyg-form').submit(function(event) {
    $('#textarea').val($('#editor').cleanHtml());
  });

  $(".image-selector").on('click', function () {         // User clicks on radio in modal
    var media_id = $(this).attr('data-mediaid');         // Get id of image
    var path     = $(this).attr('data-filepath');        // Get filepath of image
    var alt      = $(this).attr('data-alt');             // Get alt text of image
    var featuredImage = $("#featured-image");            // Featured <img> element
    var featuredImageTitle = $("#featured-image-title"); // Title for panel
    var control = $("#media_id");                        // Hidden form control
    featuredImage.attr('src', '../CMS/' + path);             // Update src of image
    featuredImage.attr('alt', alt);                      // Update alt of image
    featuredImage.removeClass('hidden');                 // Remove hidden class from image
    featuredImageTitle.html(alt);                        // Update title of panel
    control.val(media_id);                               // Update hidden form control
  });

});
</script>

  </body>
</html>