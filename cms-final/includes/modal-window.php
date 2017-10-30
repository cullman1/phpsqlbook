<?php if(defined('ROOT')) { ?>
<link href="<?= ROOT ?>lib/croppie/croppie.css" rel="stylesheet" type="text/css">
<script src="<?= ROOT ?>lib/croppie/croppie.js"></script>
<script type="text/javascript">
  $(function() {
    var $uploadCrop;

    function readFile(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $uploadCrop.croppie('bind', { url: e.target.result } );
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

      $uploadCrop = $('#picture').croppie({
      viewport: { width: 600, height: 360  },
      boundary: { width: 700, height: 400 }
    });

    $('#file').on('change', function () {
         readFile(this);
         $('.photocropper').show();
         $('#imageModal').modal('show');
       });

    $('.btn-crop').on('click', function (e) {
      $uploadCrop.croppie('result', {
        type: 'canvas',
        size:  { width: 600, height: 360 },
        enableExif: false,
        enforceBoundary: true
      }).then(function (croppedimage) {
        $('#imagebase64').val(croppedimage);
      }).then(function() {
        $('#imageModal').modal('toggle');
        $('#crop-success').show();
      });
    });

       $('#file').on('change', function () {
         readFile(this);
         $('.photocropper').show();
         $('#imageModal').modal('show');
       });

     $('#btn-close').on('click', function (e) {
       resetFormElement();
     });

  });

  function resetFormElement() {
     //This empties the file control if the image isn't cropped and the modal closed.
   $('#file').wrap('<form>').closest('form').get(0).reset();
   $('#file').unwrap();
  }
</script>
<?php } ?>
<div class="modal fade" tabindex="-1" role="dialog" id="imageModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Crop image</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body"> 
        <style> 
         .cr-image { opacity: 1 !important; }
        </style><!-- /.inline style needed otherwise picture doesn't appear when modal window opened, this is a modal specific issue-->
        <section>
          <div id="modal-page">
            <div class="photocropper" style="display:none">
              <div id="picture"></div>
            </div>
            <a href="#" class="btn-crop btn btn-primary">Crop image</a>
          </div>
        </section>
      </div><!-- /.modal-body -->
      <div class="modal-footer"></div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
