<?php

require_once 'config.php';

if (isset($_GET['title']) ) {                           // If title exists
    $title = $_GET['title'];                              // Get title
    $article = $articleManager->getArticleBySeoTitle($title);          // Get article
    $comments  = $articleManager->getCommentsByArticleId($article->id); 
  $comments  = ( ($comments) ? $comments : array() );
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
    <div class="comment">
      <img class="user-thumb" src="../../uploads/<?= $comment->image ?>">
 
      <span class="author"><?= $comment->author ?></span><br>
      <span class="date"><?= $comment->posted; ?></span>
      <p><?= $comment->comment ?></p>
    </div>
  <?php } ?>
  <?php if ($userManager->isLoggedIn()) { ?>
    <form method="post" action="<?= ROOT ?>add_comment?id=<?= $article->id ?>">
      Comment: <textarea id="comment" name="comment"></textarea><br/>
      <button type="submit" >Submit Comment</button>
    </form>
  <?php } else { ?>
    <a href="<?= ROOT ?>members/login.php">Log in to add your own comment.</a>
  <?php } ?>
</div>
</section>

<?php include 'includes/footer.php'; ?>