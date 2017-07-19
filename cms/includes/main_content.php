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
  $comments  = (($comments) ? sort_comments($comments) : array() )
?>

<div class="comments">
 <h2>Comments</h2>
  <?php foreach ($comments as $Comment) { var_dump($Comment); ?>   
  
    <div class="comment <?php if ($Comment->reply_to) { echo 'reply'; } ?>" 
         id="comment-<?= $Comment->id ?>" data-reply-to="reply-<?= $Comment->reply_to_id ?>" 
data-parent="parent-<?= $Comment->parent_id ?>">
      <img class="user-thumb" src="../../uploads/<?= $Comment->image ?>" 
           alt="<?= $Comment->author ?>">
      <span class="author"><?= $Comment->author ?></span>
      <?php if ($Comment->reply_to_id) { ?>
        <span class="reply_to"> &lt; In reply to: <?= $Comment->reply_to ?></span>
      <?php } ?>
      <i><?= format_date($Comment->posted) ?></i>
      <p><?= $Comment->comment ?></p>
    </div>
  <?php } ?>
    

</div>

<?php  if ($logged_in) { ?>
<script>
var form;          // The HTML form to add
var comment_id;    // The comment id
var reply_to_id;   // The post being replied to
var parent_id;     // The original comment
var link;          // The link to add after a comment
var form;          // The form to append

$('div.comment').each(function() {

  link        = '<a href=\"#\" class=\"link-reply\">Reply<\/a>';
  $(this).append(link);
})

$('.link-reply').on('click', function() {
  comment_id  = $(this).prev().id;
  reply_to_id = $(this).prev().attr('data-reply-to');
  parent_id   = $(this).prev().attr('data-parent');
  form        = '<form method=\"post\" '; 
  form       += 'action=\"/phpsqlbook/cms/add_comment?id=<?= $Article->id ?>';
  form       += '&comment_id=' + comment_id + '&reply_to_id=' + reply_to_id;
  form       += '&parent=' + parent_id + '\">';
  form       += '<label for=\"reply\">Reply:</label>';
  form       += '<textarea id=\"reply\" name=\"comment\"></textarea><br/>';
  form       += '<button type=\"submit\" >Submit reply</button>';
  form       += '</form>';
  $(this).after(form); 
$(this).remove();
});
</script>
<?php } else { ?>
<a href="/login/">Log in to add your own comment.</a>
<?php } ?>
</div><br/>