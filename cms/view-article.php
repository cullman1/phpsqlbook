<?php

require_once 'config.php';

if (isset($_GET['title']) ) {                           // If title exists
    $title = $_GET['title'];                              // Get title
    $article = $articleManager->getArticleBySeoTitle($title);          // Get article
    $comments  = $articleManager->getCommentsAndRepliesByArticleId($article->id); 
    $comments  = ( ($comments) ? $articleManager->sortComments($comments) : array() );
}

if (empty($article)) {
    header( "Location: page-not-found.php" );
}

$page_title      .= $article->title . ' ' . $article->category . ' by ' . $article->author;
$meta_description = $article->summary;
include 'includes/header.php';
?>

<section>
  <h1><?= $article->title ?></h1>
  <?= $article->content ?>   <br />   <br />
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
    <i class="fa fa-comment-o"></i> <?= $article->comment_count; ?> 
  <img src="<?= $article->media_filepath ?>" alt="<?= $article->media_alt ?>" /><br />   <br />
  <div class="credit">
    <img src="uploads/user/<?= $article->author_image ?>" alt="<?= $article->author ?>" />
    Posted by <i><?= $article->author ?></i> on <i><?= $article->created ?></i> in <i><?= $article->category ?></i>.
  </div>
   
    
     <div class="comments">
  <h2>Comments</h2>
  <?php foreach ($comments as $comment) { ?>
    <div class="comment <?php if ($comment->reply_to) { echo 'reply'; } ?>" 
       data-comment="<?= $comment->id ?>" data-parent="<?= $comment->parent_id ?>">
      <img class="user-thumb" src="../../uploads/<?= $comment->image ?>">
 
      <span class="author"><?= $comment->author ?></span><br>
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

             $('div.comment').each(function () {
                 $(this).append('<a href=\"#\" class=\"link-reply\">Reply<\/a>');
             })

             $('.link-reply').on('click', function () {
                 reply_to_id = $(this).parent().attr('data-comment');
                 parent_id = $(this).parent().attr('data-parent');
                 if (parent_id == '0') { parent_id = reply_to_id; }
                 form = '<form method=\"post\" ';
                 form += 'action=\"<?= ROOT ?>add_comment_reply?id=<?= $article->id ?>';
  form += '&reply_to_id=' + reply_to_id + '&parent_id=' + parent_id + '\">';
  form += 'Reply: <textarea id=\"reply\" name=\"comment\"></textarea><br/>';
  form += '<button type=\"submit\" >Submit reply</button></form>';
  $(this).after(form);
  $(this).remove();
});
</script>
  <?php } else { ?>
    <a href="<?= ROOT ?>members/login.php">Log in to add your own comment.</a>
  <?php } ?>
</div>
</section>

<?php include 'includes/footer.php'; ?>