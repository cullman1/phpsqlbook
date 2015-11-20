<?php       include '../includes/header-register.php';

function file_upload($file) {
  $msg = "";
  if ($file['tmp_name'] == "") {
     $msg = 'Your image did not upload.';
   } else {
     $filename = $file['name'];
     $folder = "../uploads/";
    if (move_uploaded_file($file['tmp_name']. $folder . $filename)) {
       $msg = 'Your file ' .  $filename . ' uploaded successfully';
     } else {
     $msg = 'Your file ' .  $filename . ' could not be saved.';
      }

   }
   return $msg;
}
 if(isset($_FILES['image_upload'])) {
    $msg = file_upload($_FILES['image_upload']);
    echo $msg;
 } else { ?>
<h2>Upload an Image</h2><br />
    <form method="post" action="file_upload.php"  enctype="multipart/form-data">
      <label>Upload file: <input type="file" name="image_upload" /></label><br/>
      <button type="submit" name="Submitted" value="sent">Submit</button>
    </form>
<?php } ?>
<?php include '../includes/footer-site.php' ?>  
