<?php 
$images = get_images_list();
?>

<div class="modal fade" tabindex="-1" role="dialog" id="imagesModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select image</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
        <div class="row">
          <?php 
          if (isset($images)) {                       // If you have images
            foreach ($images as $image) {             // Loop through them ?>
              <div class="panel panel-default col-md-3">
                <div class="panel-body">
                  <a href="#" class="image-selector" data-id="<?= $image->id; ?>" data-filepath="<?=$image->thumb;?>" data-alt="<?=$image->alt;?>" class="image-selector">
                    <img src="<?= $image->thumb ?>" alt="<?= $image->alt ?>" title="<?= $image->title ?>" />
                    <?= $image->title; ?>
                  </a>
                </div><!-- /.panel-body -->
              </div><!-- /.panel -->
            <?php 
            } // End loop code block
          }  // End if
          ?>
        </div>
      </div><!-- /.modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div><!-- /.modal-footer -->
    </div> <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->