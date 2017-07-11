<div class="content-box">
  <h3 class="heading"><a href="<?= $GLOBALS["root"]; ?><?= $Article->name ?>/<?= $Article->seo_title ?>"><?= $Article->title ?></a></h3>
  <?php if ($Article->template != 'general') {  ?>
    <h5><?= $Article->published ?></h5>
    <a href="<?= $GLOBALS['root']; ?>author/<?= $Article->forename ?>-<?= $Article->surname ?>"><?= $Article->forename ?> <?= $Article->surname ?></a><br/><br/>
  <?php } ?>
 <?php echo $Article->content ?><br/><br/>
    <?php if ($Article->template != 'general') { 
            if ( isset($_SESSION['user_id'])) { 
              echo get_like_button( $Article->id,$Article->liked) . '</a>';
            } else { ?>
             <i class="fa fa-heart-o" aria-hidden="true"></i>  
      <?php } ?>
      <?= $Article->like_count; ?>  
      <i class="fa fa-comment-o" aria-hidden="true"></i>  <?= $Article->comment_count ?> 
<?php } ?>
  
<!-- Changed //--> 
<div id="comments" class="comments-list">
  <?php
    $comments = get_nested_comments_by_article_id($Article->id);
   if ($comments) {
    $comments = sort_comments($comments); 
    foreach ($comments as $Comment) { 
      $reply = (($Comment->repliedto_id)!=0) ? ' depth-1' : '';
      $path = 'http://localhost/phpsqlbook/uploads/' .  $Comment->image;
  ?>
  <div class="border comment-box <?= $reply ?>">
    <img class="comment_reply user_thumb" src="<?= $path ?>" type="image/jpg" />
    <a class="user_name" href="/phpsqlbook/cms/profile?id=<?=  $Comment->user_id ?>"><?= $Comment->forename  ?> <?= $Comment->surname ?>
    <?php if ($Comment->repliedto_id !=0) { ?>
      <span class="reply_to"> &lt; In reply to: <?= $Comment->commenterfirst ?> <?= $Comment->commenterlast ?></span>
    <?php } ?>
    <hr class="comment_divider" /><p class="time_elapsed"><?= time_elapsed($Comment->posted) ?> </p></a>
    <?php if (isset($_SESSION["user_id"])) { ?>
      <a data-id="<?= $Comment->forename  ?> <?= $Comment->surname ?>" class="link-form" id="link<?= $Comment->id ?>" href="#">Reply</a>
    <?php } ?>
    <span class="comment_reply_below"><?= $Comment->comment ?></span><span id="comlink<?= $Comment->id ?>"></span>
   </div>
  <?php } 
} ?>
</div>

<?php  if ( isset($_SESSION['user_id'])) { ?>
   <br/> <a class="link-form add-link" id="link0" href="#">Add a comment</a><span id="comlink0"></span>
  <?php       $replyto = (isset($Comment)) ? $Comment->repliedto_id : '0';
   $parent = (isset($Comment)) ? $Comment->toplevelparent_id: '0';?>
<form id="form-comment" class="bold" method="post" style="display:none;"/action="/phpsqlbook/cms/add_comment?article_id=<?= $Article->id ?>&parent=<?= $parent ?>&reply=<?= $replyto ?>" >
<span id="reply_name"></span>
<label for="comment">Comment:</label>
 <textarea id="comment" name="comment"></textarea><br/>
 <button type="submit" >Submit Comment</button>
 </form>
<script>
$(".link-form").each(function() { 
  $(this).click(function() { 
    var act = "/phpsqlbook/cms/add_comment?article_id=<?= $Article->id ?>&parent=<?= $parent ?>&reply=<?= $replyto ?>";
    if (! $("#form-comment").is(":visible")) {  
      if( $("a:focus").attr("data-id")!=null ) { 
        $("#reply_name").html("<?= $_SESSION['name'] ?> > replying to: " + $("a:focus").attr("data-id")); 
      } 
      $("#form-comment").attr("action", act + event.target.id ); 
      if (event.target.id == "link0" ) {
        $("#reply_name").html("" ); 
      } 
      $("#form-comment").appendTo("#com" + event.target.id); 
    }
   $("#form-comment").toggle(); 
  });   
}); 
</script>   
 <?php   } ?>

</div><br/>