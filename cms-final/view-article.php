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

if (!(isset($article_images)) || sizeof($article_images)<1) {
  $article_images = array();
}

$page_title      .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';
?>

<section>
  <h1><?= $article->title ?></h1>
  <?= $article->content ?>
  <?php foreach ($article_images as $image) {
    echo '<img src="../uploads/' . $image->filename . '" alt="' . $image->alt . '" />';
  }
  ?>
  <div class="credit">
    Posted by <i><?= $article->author ?></i>
    on <i><?= $article->created ?></i> in <i><?= $article->category ?></i>.
  </div>
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
<?= $article->like_count; ?>
</section>
<i class="fa fa-comment-o"></i> <?= $article->comment_count; ?> 
<div class="comments">
  <h2>Comments</h2>
  <?php if ($userManager->isLoggedIn()) { ?>
    <h4>Add a comment</h4>
    <form method="post" action="<?= ROOT ?>add_comment?id=<?= $article->id ?>">
      <textarea id="comment" name="comment"></textarea><br/>
      <button type="submit" >Submit Comment</button>
    </form>
  <?php } ?>

  <?php foreach ($comments as $comment) { ?>
    <div class="comment <?php if ($comment->reply_to) { echo 'reply'; } ?>" 
       data-comment="<?= $comment->id ?>" data-parent="<?= $comment->parent_id ?>">
      <span class="author"><?= $comment->author ?></span>
       <?php if ($comment->reply_to_id) { ?>
        <span class="reply_to"> &lt; In reply to: <?= $comment->reply_to ?></span>
      <?php } ?>
      <span class="date"><?= $comment->posted; ?></span>
      <p><?= $comment->comment ?></p>
    </div>
  <?php } ?>
  <?php if ($userManager->isLoggedIn()) { ?>
    <script>
      var form, reply_to_id, parent_id;

      $('div.comment').each(function() {
        $(this).append('<a href=\"#\" class=\"link-reply\">Reply<\/a>');
      })

      $('.link-reply').on('click', function() {
        reply_to_id = $(this).parent().attr('data-comment');
        parent_id   = $(this).parent().attr('data-parent');
        if (parent_id == '0') { parent_id = reply_to_id; }
        form        = '<form method=\"post\" ';
        form       += 'action=\"http://<?=$_SERVER['HTTP_HOST']?><?= ROOT ?>add_comment_reply?id=<?= $article->id ?>';
        form       += '&reply_to_id=' + reply_to_id + '&parent_id=' + parent_id + '\">';
        form       += 'Reply:<br><textarea id=\"reply\" name=\"comment\"></textarea><br/>';
        form       += '<button type=\"submit\" >Submit reply</button></form>';
        $(this).after(form);
        $(this).remove();
      });
    </script>

  <?php } else { ?>
    <a href="<?= ROOT ?>users/login.php">Log in to add your own comment.</a>
  <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>