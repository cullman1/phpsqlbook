<!-- IMAGE SELECTOR MODAL -->
<?php 
$images = get_images_list();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="imagesModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Select image</h4>
      </div>
      <div class="modal-body">
      <?php 
      if (isset($images)) {                                     // If you have images
      foreach ($images as $image) {                             // Loop through them ?>
        <div class="col-md-3" id="thumbnails" data-insert="">
          <div class="panel panel-default">
            <div class="panel-heading">
              <input type="radio" name="featured" value="<?= $image->id; ?>" data-filepath="<?=$image->thumb; ?>" data-alt="<?=$image->alt;?>"  class="image-selector" />
              <?= $image->title; ?><br>
            </div>
            <div class="panel-body" style="overflow:auto;">
              <img src="../CMS/<?php if ($image->thumb!=""){echo $image->thumb;} else {echo "../uploads/holder.jpg";}?>" alt="<?= $image->alt ?>" title="<?= $image->title ?>" /><br>
            </div>
          </div>
        </div>
        <?php 
        } // End loop code block
      }  // End if
      ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
