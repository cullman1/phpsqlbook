<?php include ('../includes/header-register.php'); 
 if(!isset($_FILES['image'])) {?>
  <h2>Upload an Image</h2><br />
  <form method="post" action="file_upload_improved_short.php"  enctype="multipart/form-data">
   <label>Upload file: <input type="file" name="image[]"  
     accept="image/jpeg, image/png, image/gif" multiple /> </label><br />
    <button type="submit" name="Submitted" value="sent">Submit</button>
  </form>
  <?php } else {
 foreach($_FILES['image']['tmp_name'] as $key =>$tmp_name) {
     $type=  $_FILES["image"]["type"][$key];
   if(( $type!= "image/jpeg") && ( $type!="image/png") && ( $type[$key]!="image/gif") && ($_FILES["image"]["size"][$key]>10000000)) {
      echo 'Illegal file type or size uploaded';
    } 
   else if ($_FILES['image']['tmp_name'][$key] == "") {
      echo 'Your image did not upload.';
    } else {
      $filename = $_FILES['image']['name'][$key];
     if(move_uploaded_file($_FILES['image']['tmp_name'][$key],"../uploads/". $filename)) {
         echo 'Your file ' . $filename. ' uploaded successfully.<br/>';
      } else {
          echo 'Your image '. $filename .' could not be saved.<br/>';
      }
    }
  }
} ?>
<?php include '../includes/footer-site.php' ?>