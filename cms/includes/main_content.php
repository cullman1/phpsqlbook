<div class="content-box">
  <h3 class="heading"><a href="<?= $GLOBALS["root"]; ?><?= $Article->name ?>/<?= $Article->seo_title ?>"><?= $Article->title ?></a></h3>
    <h5><?= $Article->published ?></h5>
    <a href="<?= $GLOBALS['root']; ?>author/<?= $Article->forename ?>-<?= $Article->surname ?>"><?= $Article->forename ?> <?= $Article->surname ?></a><br/><br/>
 <?php echo $Article->content;
$logged_in = (isset($_SESSION['user_id']) ? TRUE : FALSE);  
 ?>
<br/><br/>
 <?php 
if ($logged_in) {
 if ($Article->liked) {
    echo '<a href="/phpsqlbook/cms/unlike?id=' . $Article->id . '">
          <i class="fa fa-heart"></i></a> ';
  } else {
    echo '<a href="/phpsqlbook/cms/like?id=' . $Article->id . '">
          <i class="fa fa-heart-o"></i></a> ';
  }
} else {
    echo '<i class="fa fa-heart-o"></i> ';
}
?>
<?= $Article->like_count; ?>
      <i class="fa fa-comment-o" aria-hidden="true"></i>  <?= $Article->comment_count ?> 
<?php 
  if (!$Article) {
    header( "Location: index.php" );
  } 
  $logged_in = (isset($_SESSION['user_id']) ? TRUE : FALSE);
  $comments  = get_comments_and_replies_by_article_id($Article->id);
  $comments  = ( ($comments) ? sort_comments($comments) : array() );
?>
<div class="comments">
 <h2>Comments</h2>
 <?php foreach ($comments as $Comment) { ?>   
    <div class="comment <?php if ($Comment->reply_to) { echo 'reply'; } ?>" 
       data-comment="<?= $Comment->id ?>" data-parent="<?= $Comment->parent_id ?>">
      <img class="user-thumb" src="../../uploads/<?= $Comment->image ?>" 
           alt="<?= $Comment->author ?>">
      <span class="author"><?= $Comment->author ?></span>
      <?php if ($Comment->reply_to_id) { ?>
        <span class="reply_to"> &lt; In reply to: <?= $Comment->reply_to ?></span>
      <?php } ?>
     <br/> <i><?= format_date($Comment->posted) ?></i><br/><br/><br/>
      <p><?= $Comment->comment ?></p>
    </div>
  <?php } ?>
</div>
<?php if ($logged_in) { ?>
<script>
var form, reply_to_id, parent_id;

$('div.comment').each(function() {
  $(this).append('<a href=\"#\" class=\"link-reply\">Reply<\/a>');
})

$('.link-reply').on('click', function() {
  reply_to_id = $(this).parent().attr('data-comment');
  parent_id   = $(this).parent().attr('data-parent');
  if (parent_id == 0) { parent_id = reply_to_id; }
  form        = '<form method=\"post\" '; 
  form       += 'action=\"/phpsqlbook/cms/add_comment_reply?id=<?= $Article->id ?>';
  form       += '&reply_to_id=' + reply_to_id + '&parent_id=' + parent_id + '\">';
  form       += 'Reply: <textarea id=\"reply\" name=\"comment\"></textarea><br/>';
  form       += '<button type=\"submit\" >Submit reply</button></form>';
  $(this).after(form); 
  $(this).remove();
});
</script>
<?php } ?>
<?php if ($logged_in) { ?>
    <form method="post" action="/phpsqlbook/cms/add_comment?id=<?= $Article->id ?>">
      Comment: <textarea id="comment" name="comment"></textarea><br/>
      <button type="submit" >Submit Comment</button>
    </form>
  <?php } else { ?>
    <a href="/login/">Log in to add your own comment.</a>
  <?php } ?>

</div><br/>