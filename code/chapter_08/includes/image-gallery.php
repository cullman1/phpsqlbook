<?php 
  $images = get_images_list();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="imagesModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><!-- modal header and close button--></div>
      <div class="modal-body">
      <?php 
      if (isset($images)) {                       // If you have images
        foreach ($images as $image) {             // Loop through them ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <input type="radio" name="featured" value="<?= $image->id; ?>" 
                class="image-selector" data-alt="<?=$image->alt;?>"
                data-filepath="<?= $image->thumb;?>"  />
                <?= $image->title; ?>
            </div><!-- /.panel-heading -->
            <div class="panel-body">
              <img title="<?= $image->title ?>" alt="<?= $image->alt ?>" 
                src="<?php if ($image->thumb!=""){echo $image->thumb;}
                              else {echo "../uploads/holder.jpg";}?>" />           
           </div><!-- /.panel-body -->
          </div><!-- /.panel -->
        <?php 
        } // End loop code block
      }  // End if
      ?>
      </div><!-- /.modal-body -->
      <div class="modal-footer"> <!-- modal footer and close button--></div>
    </div> <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->