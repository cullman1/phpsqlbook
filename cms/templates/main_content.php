<div style="padding-left:10px;width:820px;">
 <h3 style="text-align:left;"><u><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></u>  </h3>
 <?php if ($object->template != 'general') {  ?>
  <h5><?php echo $object->published ?></h5>
  <a href="<?php echo $GLOBALS['root']; ?>author/<?php echo $object->forename ?>-<?php echo $object->surname ?>"><?php echo $object->forename ?> <?php echo $object->surname ?></a><br/><br/>
  <?php } ?>
 <div class="box" style="width:800px;"><?php echo $object->content ?></div><br/>
  <?php if ($object->template != 'general') {  ?>
    <?php echo 'Likes: '.get_like_total($object->id); ?>  
    <div style="float:right; padding-right: 30px;"><?php echo 'Comments: '.get_comment_total($object->id); ?></div>
     <?php } ?>
<!-- only show if logged in and not on an about/contact page  -  &&  (basename($_SERVER['PHP_SELF'])=="article.php")//-->
<?php if ( isset($_SESSION['user_id']) && ($object->template != 'general')) { ?>
 <?php echo get_like_button($_SESSION['user_id'], $object->id); ?>  
  <?php } ?>
  <?php if ( isset($_SESSION['user_id']) && ($object->template != 'general')  &&  (basename($_SERVER['PHP_SELF'])=="article.php")) { ?>
 <?php echo get_comments_list($_SESSION['user_id'], $object->id); ?>  
  <?php } ?>
</div>
<br/>