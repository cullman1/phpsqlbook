<div class="content-page">
  <h3 style="text-align:left;"><u><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></u>  </h3>
  <?php if ($object->template != 'general') {  ?>
  <img src="../../<?php echo $object->thumb ?>" />
    <br/><br/>
  <?php } ?>

    <?php if ($object->template != 'general') {  ?>
      <?php echo 'Likes: '. $object->like_count; ?>  
      <div class="comment-total"><?php echo 'Comments: '.$object->comment_count; ?></div>
    <?php } ?>
  <?php if ( isset($_SESSION['user_id']) && ($object->template != 'general')) { ?>
    <?php echo get_like_button($_SESSION['user_id'], $object->id); ?>  
  <?php } ?>
</div><br/>