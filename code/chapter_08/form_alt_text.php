<?php
if(!isset($_FILES['image_upload'])) {
?>
    <h2>Upload an Image</h2><br />
    <form method="post" action="file_upload.php"  enctype="multipart/form-data">
      <label>Upload file: <input type="file" name="image_upload" 
       accept="image/jpeg, image/png, image/gif" /></label><br/>
      <button type="submit" name="Submitted" value="sent">Submit</button>
    </form>
  <?php 
} else {
    if (($_FILES["image_upload"]["type"] != "image/jpeg") && ($_FILES["image_upload"]   
    ["type"] != "image/png") && ($_FILES["image_upload"]["type"] != "image/gif")) {    
        echo 'Illegal file type uploaded';
    }
    else if ($_FILES['image_upload']['tmp_name'] == "") {
        echo 'Your image did not upload.';
    } else {
        $folder = "../uploads/";
        $filename = ($_FILES['image_upload']['tmp_name']);
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder . $filename)) {
            echo 'Your file' . $_FILES['image_upload']['name'] . 'uploaded successfully';
        } else {
            echo 'Your image could not be saved.';
        }
    }
}
  ?>
