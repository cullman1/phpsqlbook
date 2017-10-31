<?php
if(isset($_POST['imagedata'])){
  $data = $_POST['imagedata'];
  $title = $_POST['title'];
  list($type, $data) = explode(';', $data);
  list(, $data)      = explode(',', $data);
  $data = base64_decode($data);
  file_put_contents($title. '.png', $data);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Cropping and resizing before upload</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link href="lib/croppie/croppie.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="lib/jquery/jquery-1.12.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script> 
 <script type="text/javascript" src="lib/croppie/croppie.js"></script>
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

      $('.btn-crop').on('click', function () {
        $uploadCrop.croppie('result', {
          type: 'canvas',
          size:  { width: 600, height: 360 }
        }).then(function (croppedimage) {
          $('#imagedata').val(croppedimage);
          //$('#form').submit();
        }).then(function() {
        $('#imageModal').modal('toggle');
        $('#crop-success').show();
      });
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
</head>
<body>

<div>  <input type="file" id="file"><br>
  Title: <input type="text" name="title"><br></div>

<div class="modal" tabindex="-1" role="dialog" id="imageModal">
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
            <form action="" id="form" method="post">


  <div id="picture"></div>

  <input type="hidden" id="imagedata" name="imagedata">

  <a href="#" class="btn-crop">Crop</a>
</form>
</div>
          </div>
        </section>
      </div><!-- /.modal-body -->
      <div class="modal-footer"></div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>