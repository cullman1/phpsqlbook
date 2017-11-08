<?php
// function to show the form
function get_image_upload_form() { 
  $form = '<form method="post" action="" enctype="multipart/form-data">
    <label>Upload file: <input type="file" name="image" accept="image/*" /></label>
    <button type="submit" name="submitted" value="sent">Submit</button>
  </form>';
  return $form;
} 

function upload_file($file_data) {
  if ($file_data['tmp_name'] == '') {
    $message = 'Your image did not upload.';
  } else {
    $temporary   = $file_data['tmp_name'];
    $destination = '../uploads/' . $file_data['name'];
    if (move_uploaded_file($temporary, $destination)) {
      $message = '<img src="'.$destination.'">';
    } else {
      $message = 'Your file was not uploaded. Here is your debug informations:'.print_r($_FILES);
    }
  }
  return $message;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Upload file then move</title>
  </head>
  <body>

  <?php
  if(!isset($_FILES['image'])) {
    echo get_image_upload_form();
  } else {
    echo upload_file($_FILES['image']);
  }
  ?>

  </body>
</html>