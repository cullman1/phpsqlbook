<div class="content-box">
  <h3 class="heading"><a href="<?= $GLOBALS["root"]; ?><?= $Article->name ?>/<?= $Article->seo_title ?>"><?= $Article->title ?></a></h3>
  <?php if ($Article->template != 'general') {  ?>
    <h5><?= $Article->published ?></h5>
    <a href="<?= $GLOBALS['root']; ?>author/<?= $Article->forename ?>-<?= $Article->surname ?>"><?= $Article->forename ?> <?= $Article->surname ?></a><br/><br/>
  <?php } ?>
 <?php echo $Article->content ?><br/><br/>
    <?php 
if (isset($_SESSION['user_id'])) {        // change to if logged in
  if ($Article->liked == NULL) {
    echo'<a href="unlike?id=' . $Article->id . '">';
    echo '<i class="fa fa-heart-o" aria-hidden="true"></i></a>';
  } else {
    echo '<a href="like?id=' . $Article->id . '">';
    echo '<i class="fa fa-heart" aria-hidden="true"></i></a>';
  }
} else {
    echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
}
?>
      <?= $Article->like_count; ?>  
      <i class="fa fa-comment-o" aria-hidden="true"></i>  <?= $Article->comment_count ?> 
  
<?php 
  if (!$Article) {
    header( "Location: index.php" );
  } 
  $logged_in = (isset($_SESSION['user_id']) ? TRUE : FALSE);
  $comments  = (get_nested_comments_by_article_id($Article->id)) 
               ? get_nested_comments_by_article_id($Article->id) : array(); 
  $comments  = sort_comments($comments);
?>

<div class="comments">
  <h2>Comments</h2>
  <?php foreach ($comments as $Comment) {
 ?>   
    <div class="comment <?php if ($Comment->reply_to_id) { echo 'reply'; } ?>" 
         id="comment-<?= $Comment->id ?>"  data-parent="parent-<?= $Comment->parent_id ?>" data-reply_to="reply-<?= $Comment->reply_to_id ?>">
      <img class="user-thumb" src="../../uploads/<?= $Comment->image ?>" 
           alt="<?= $Comment->author ?>">
      <span class="author"><?= $Comment->author ?></span>
      <?php if ($Comment->reply_to_id) { ?>
        <span class="reply_to"> &lt; In reply to: <?= $Comment->reply_to_name ?></span>
      <?php } ?>
 <br>      <i><?= format_date($Comment->posted) ?></i> <br>
      <p><?= $Comment->comment ?></p>
      <br>
    </div>
  <?php } ?>

  <?php if ($logged_in) { ?>
    <form id="form-comment" method="post" action="add_comment?id=<?= $Article->id ?>">
      <label for="comment">Comment:</label>
      <textarea id="comment" name="comment"></textarea><br/>
      <button type="submit" >Submit Comment</button>';
    </form>
  <?php } else { ?>
    <a href="/login/">Log in to add your own comment.</a>
  <?php } ?>

</div>

<?php  if ( isset($_SESSION['user_id'])) { ?>
<script>
var form;          // The HTML form to add
var reply_to_id;   // The post being replied to
var parent_id;     // The original comment
var link;          // The link to add after a comment
var form;          // The form to append

$(".comment").each(function() {
  comment_id = this.id;
  reply_to_id = $(this).attr('data-reply_to');
 
  parent_id   = $(this).attr('data-parent');
  link = "<a href=\"#\" class=\"link-reply\" id=\"" + comment_id + "\" data-reply_to=\"" + reply_to_id + "\" data-parent=\"" + parent_id +  "\">Reply<\/a>";
  $(this).append(link);
})

$(".link-reply").on("click", function() {
  comment_id = this.id;
  reply_to_id = $(this).attr('data-reply_to');
  parent_id   = $(this).attr('data-parent');
  form        = "<form method=\"post\" "; 
  form       += "action=\"/phpsqlbook/cms/add_comment?id=<?= $Article->id ?>";
  form       += "&reply_to=" + reply_to_id + "&comment_id=" + comment_id+ "&parent=" + parent_id + "\">";
  form       += "<label for=\"reply\">Reply:</label>";
  form       += "<textarea id=\"reply\" name=\"comment\"></textarea><br/>";
  form       += "<button type=\"submit\" >Submit reply</button>";
  form       += "</form>";
  $(this).after(form); 
$(this).remove();
});
</script>
<?php } ?>
</div><br/>