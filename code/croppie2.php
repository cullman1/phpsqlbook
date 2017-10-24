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
  <link href="lib/croppie/croppie.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="lib/jquery/jquery-1.12.4.min.js"></script>
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
      });

      $('.btn-crop').on('click', function () {
        $uploadCrop.croppie('result', {
          type: 'canvas',
          size:  { width: 600, height: 360 }
        }).then(function (croppedimage) {
          $('#imagedata').val(croppedimage);
          $('#form').submit();
        })
      });

    });
  </script>
</head>
<body>

<form action="" id="form" method="post">
  <input type="file" id="file"><br>
  Title: <input type="text" name="title"><br>

  <div id="picture"></div>

  <input type="hidden" id="imagedata" name="imagedata">

  <a href="#" class="btn-crop">Crop</a>
</form>

</body>
</html>