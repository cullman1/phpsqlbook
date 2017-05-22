<div style="padding-left:10px;">
 <h3 style="text-align:left;"><u><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></u>  </h3>
<?php if ($object->template != 'general') {  ?>
  <h5><?php echo $object->published ?></h5><br/>
  <?php } ?>
 <div class="box" style="width:800px;"><?php echo $object->content ?></div>
</div>
<br/>