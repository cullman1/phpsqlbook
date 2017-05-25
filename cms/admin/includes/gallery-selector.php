<?php 
$galleries = get_gallery_list();
?>

<div class="modal fade" tabindex="-1" role="dialog" id="galleriesModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select gallery</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
        <div class="row">
          <?php 
          if (isset($galleries)) {                       // If you have images
            foreach ($galleries as $Gallery) {             // Loop through them
              $Media = get_first_image_from_gallery($Gallery->id);
              ?>
              <div class="panel panel-default col-md-3">
                <div class="panel-body">
                  <a href="#" class="gallery-selector" data-id="<?= $Gallery->id; ?>" data-filepath="<?=$Media->thumb;?>" data-alt="<?=$Media->alt;?>" class="gallery-selector">
                    <img src="<?= $Media->thumb ?>" alt="<?= $Media->alt ?>" />
                    <?= $Gallery->name; ?>
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