<?php
// function to show the form
function get_image_upload_form() { 
  $form = '<form method="post" action="" enctype="multipart/form-data">
    <label>Upload file: <input type="file" name="image" accept="image/*" /></label>
    <button type="submit" name="submitted" value="sent">Submit</button>
  </form>';
  return $form;
} 



function sanitise_name($file) {
  $file = preg_replace("([^\w\d\-_~,;.])",'',$file);
  $file = preg_replace("([\.]{2,})", '', $file); 
  $file = preg_replace("([\~,;])", '-', $file);
  return $file;
}


// function to display data from image
function display_file_info($file_data) {
  $message = '';
  if ($file_data['tmp_name'] == "") {
    $message = 'Your image did not upload.';
  } else {
    foreach ($file_data as $key => $value) {
      $message .= $key . ': ' . $value . '<br>';
    }
  }
  return $message;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Upload file / show info</title>
  </head>
  <body>

  <?php
  if(!isset($_FILES['image'])) {
    echo get_image_upload_form();
  } else {
    $_FILES['image']['name'] = sanitise_name($_FILES['image']['name']);
    echo display_file_info($_FILES['image']);
  }
  ?>

  </body>
</html>