<?php

require_once 'config.php';

if (isset($_GET['title']) ) {                                        // If title exists
  $title = $_GET['title'];                                           // Get title
  $article = $articleManager->getArticleBySeoTitle($title);          // Get article
  $article_images = $articleManager->getArticleImages($article->id);
  $comments  = $articleManager->getCommentsAndRepliesByArticleId($article->id);
  $comments  = ( ($comments) ? $articleManager->sortComments($comments) : array() );

}
if (empty($article)) {
   // header( "Location: page-not-found.php" );
}

$info  = (isset($_GET['info']) ? 'info' : '');                 // Is it an info page

if (!(isset($article_images)) || sizeof($article_images)<1) {
  $article_images = array(new Media());
}

$page_title      .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';
?>

<section>

  <h1 class="display-4"><?= $article->title ?></h1>

  <div class="credit <?=$info?>">
    <?= $article->category ?> by <a href="<?= ROOT ?>users/<?= $article->seo_user ?>"><?= $article->author ?></a> on <i><?= $article->created ?></i>.
  </div>

  <div class="row">
    <div class="col-8">

    <?php if (sizeof($article_images) < 2) { ?>
      <img src="../uploads/<?= $article_images[0]->filename?>" alt="<?=$article_images[0]->alt?>"/>
    <?php } else { ?>
      <div class="gallery">
        <div id="photo-viewer"></div>
        <div id="thumbnails">
        <?php foreach ($article_images as $image) { ?>
            <a href="../uploads/<?=$image->filename?>" alt="<?=$image->alt?>" class="thumb" />
            <img src="../uploads/thumb/<?=$image->filename?>" alt="<?=$image->alt?>"/></a>
        <?php } ?>
        </div>
      </div>
    <?php  } ?>
    </div>

    <div class="col-4">

      <div class="like-comment-count <?=$info?>">
        <?php
          if ($userManager->isLoggedIn()) {
            if ($article->liked) {
              echo '<a href="' . ROOT . 'unlike?id=' . $article->id . '">
                <i class="fa fa-heart"></i></a> ';
            } else {
              echo '<a href="' . ROOT . 'like?id=' . $article->id . '">
                <i class="fa fa-heart-o"></i></a> ';
            }
          } else {
            echo '<i class="fa fa-heart-o"></i> ';
          }
        ?>

        Likes <?= $article->like_count; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <i class="fa fa-comment-o"></i> Comments: <?= $article->comment_count; ?>

      </div>

      <?= $article->content ?>

    </div>

  </section>
  <section class="comments <?=$info?>">
    <div class="row">
      <div class="col-8">
        <h2 class="display-4">Comments</h2>
        <?php if ($userManager->isLoggedIn()) { ?>
          <form method="post" action="<?= ROOT ?>add_comment?id=<?= $article->id ?>" class="comment">
            <h4>Add a comment</h4>
            <textarea id="comment" name="comment" class="form-control"></textarea><br/>
            <button type="submit" class="btn btn-primary">Submit comment</button>
          </form>
        <?php } ?>

        <?php foreach ($comments as $comment) { ?>
          <div class="comment <?php if ($comment->reply_to) { echo 'reply'; } ?>"
             data-comment="<?= $comment->id ?>" data-parent="<?= $comment->parent_id ?>">
            <b><span class="author"><?= $comment->author ?></span></b>
            <?php if ($comment->reply_to_id) { ?>
              <span class="reply_to"> &lt; In reply to: <?= $comment->reply_to ?></span>
            <?php } ?>
            <p><?= $comment->comment ?></p>
            <div class="date"><?= $comment->posted; ?></div>
          </div>
        <?php } ?>

        <?php if ($userManager->isLoggedIn()) { ?>
          <script>
            var form, reply_to_id, parent_id;

            $('div.comment').each(function() {
              $(this).append('<a href=\"#\" class=\"link-reply btn btn-primary\">Reply<\/a>');
            })

            $('.link-reply').on('click', function() {
              reply_to_id = $(this).parent().attr('data-comment');
              parent_id   = $(this).parent().attr('data-parent');
              if (parent_id == '0') { parent_id = reply_to_id; }
              form        = '<form method=\"post\" ';
              form       += 'action=\"http://<?=$_SERVER['HTTP_HOST']?><?= ROOT ?>add_comment_reply?id=<?= $article->id ?>';
              form       += '&reply_to_id=' + reply_to_id + '&parent_id=' + parent_id + '\">';
              form       += '<label for="reply">Reply:</label><textarea id=\"reply\" name=\"comment\" class="form-control"></textarea><br/>';
              form       += '<button type=\"submit\"  class=\"btn btn-primary\">Reply</button></form>';
              $(this).after(form);
              $(this).remove();
            });

            $('#thumbnails a:first-child').addClass("active");

          </script>
        <?php } else { ?>
          <a href="<?= ROOT ?>users/login.php">Log in to add your own comment.</a>
        <?php } ?>
      </div>
    </div>
  </section>

  <script src="<?=ROOT?>lib/photoviewer/photo-viewer.js"></script>
  <script src="<?=ROOT?>lib/jquery/jquery-1.12.4.min.js"></script>

<?php include 'includes/footer.php'; ?>