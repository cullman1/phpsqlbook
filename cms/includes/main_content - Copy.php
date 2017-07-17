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
  
<!-- Changed //--> 
<div id="comments" class="comments-list">
  <?php
    $comments = (get_nested_comments_by_article_id($Article->id)) ? get_nested_comments_by_article_id($Article->id) : array(); 
    $comments = sort_comments($comments); 
    foreach ($comments as $Comment) { 
      $reply = (($Comment->reply_to_id)!=0) ? ' depth-1' : '';
      $path = 'http://'. $_SERVER['HTTP_HOST'] . '/phpsqlbook/uploads/' .  $Comment->image;
  ?>
  <div id="comment-<?= $Comment->id ?>" class="comment <?= $reply ?>">
    <img class="user_thumb" alt="<?= $Comment->author ?>" src="<?= $path ?>" />
    <a class="user_name" href="/phpsqlbook/cms/profile?id=<?=  $Comment->user_id ?>"><?= $Comment->author ?>
    <?php if (!empty($Comment->reply_to_id)) { ?>
      <span class="reply_to"> &lt; In reply to: <?= $Comment->reply_to_name ?></span>
    <?php } ?>
    <hr class="comment_divider" /><p class="time_elapsed"><?= time_elapsed($Comment->posted) ?> </p></a>
    
    <span class="comment-reply-below"><?= $Comment->comment ?></span><span id="comlink<?= $Comment->id ?>"></span>
   </div>
  <?php } 
 ?>
</div>

<?php  if ( isset($_SESSION['user_id'])) { ?>

<script>
var form;          // The HTML form to add
var comment_id;    // The comment id
var link;          // The link to add after a comment
var form;          // The form to append

$(".comment").each(function() {
  comment_id = this.id;
  comment_id = comment_id.replace("comment-", "");
  link = "<a href=\"#\" class=\"link-reply\" id=\"link-" + comment_id + "\">Reply<\/a>";
  $(this).append(link);
})

$(".link-reply").on("click", function() {
  comment_id = this.id;
  comment_id = comment_id.replace("link-", "");
 form  = "<form method=\"post\" "; 
 
   form += "action=\"/phpsqlbook/cms/add_comment?id=<?= $Article->id ?>&reply_to=" + comment_id + "\">";
     form += "<label for=\"reply\">Reply:</label>";
     form += "<textarea id=\"reply\" name=\"comment\"></textarea><br/>";
     form += "<button type=\"submit\" >Submit reply</button>";
  form += "</form>";
  $(this).after(form); 
$(this).remove();
});
</script>

<?php } ?>
</div><br/>