<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
 include '../includes/header-register.php';
require_once('../includes/db_config.php'); ?>
<?php if(!isset($_FILES['image_upload'])) { ?>
<h2>Upload an Image</h2><br />
<form method="post" action="file_upload.php"  enctype="multipart/form-data">
  <label>Upload file: <input type="file" name="img_upload" 
   accept="image/jpeg,image/png,image/gif" /></label>
   <label for="title">Image title: <input id="title" name="title" type="text"/> </label>
   <button type="submit" name="Submitted" value="sent">Upload file</button>
</form>
<?php } else {
  if (($_FILES["image_upload"]["type"] != "image/jpeg") && ($_FILES["image_upload"]   
  ["type"] != "image/png") && ($_FILES["image_upload"]["type"] != "image/gif")) {    
    echo 'Illegal file type uploaded';
  } else if ($_FILES['image_upload']['tmp_name'] == "") {
    echo 'Your image did not upload.';
  } else {
    $folder = "../uploads/";
    $filename = ($_FILES['image_upload']['tmp_name']);
    if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder . $filename)) {
      $ins_media =$dbHost->prepare("INSERT INTO media(thumbnail,alt_text,file_name,file_type,   
      file_path,file_size,date_uploaded) VALUES (:thmb,:alt,:name,:type,:path,:size,:date)");
      $ins_media->bindParam(":thmb", $thumbnail);
      $ins_media->bindParam(":alt", $_POST['title']);
      $ins_media->bindParam(":name", $_FILES['uploader']['name']);
      $ins_media->bindParam(":type",$_FILES['uploader']['type']);
      $ins_media->bindParam(":path", .$folder);
      $ins_media->bindParam(":size", $_FILES['uploader']['size']);
      $ins_media->bindParam(":date",date("Y-m-d H:i:s"));
      $ins_media->execute();
      if($insert_media_result->errorCode()==0) {
        echo 'Your file' . $_FILES['uploader']['name'] . 'uploaded successfully';
       }
    } else {
      echo 'Your image could not be saved.';
    }
  }
} ?>
<?php include '../includes/footer.php' ?>