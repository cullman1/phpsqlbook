<?php
if(isset($_POST['imagebase64'])){
  $data = $_POST['imagebase64'];
  $title = $_POST['title'];

  list($type, $data) = explode(';', $data);
  list(, $data)      = explode(',', $data);
  $data = base64_decode($data);
$source = imagecreatefromstring($data);
    $result1 =   imagejpeg($source, 'simpletext.jpg');  
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Test</title>
  <link href="css/croppie.css" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> 
  <script type="text/javascript" src="../lib/jquery/croppie.js"></script>
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
      });

      $('.btn-crop').on('click', function () {
        $uploadCrop.croppie('result', {
          type: 'canvas',
          size:  { width: 600, height: 360 }
        }).then(function (croppedimage) {
          $('#imagebase64').val(croppedimage);
        }).then(function() {
          $('#crop-success').show();
        });
      });

    });
  </script>
</head>
<body>

<form action="" id="form" method="post">
  <input type="file" id="file"><br>
  Title <input type="text" name="title"><br>
  Alt <input type="text" name="alt"><br>


  <div class="photocropper" style="display:none">
    <div id="picture"></div>
  </div>
  <div id="crop-success" class="alert alert-success" style="display:none">image cropped</div>

  <input type="hidden" id="imagebase64" name="imagebase64">

  <a href="#" class="btn-crop">Crop</a>
  <input type="submit" value="save">
</form>

</body>
</html>