<?php include ('../includes/header-register.php'); 
error_reporting(E_ALL|E_WARNING|E_NOTICE);
ini_set('display_errors', TRUE); 
function file_upload($file) {
foreach($file['tmp_name'] as $key =>$tmp_name) {
     $type=  $file["type"][$key];
   if((( $type!= "image/jpeg") && ( $type!="image/png") && ( $type[$key]!="image/gif")) || ($file["size"][$key]>10000000)) {
      echo 'Illegal file type or size uploaded';
    } else if ($file['tmp_name'][$key] == "") {
      echo 'Your image did not upload.';
    } else {
      $filename = $file['name'][$key];
     if(move_uploaded_file($file['tmp_name'][$key],"../uploads/". $filename)) {
         echo 'Your file ' . $filename. ' uploaded successfully.<br/>';
      } else {
         echo 'Your image '. $filename .' could not be saved.<br/>';
      }
    }
  }
} 
if(isset($_FILES['image'])) {
  file_upload($_FILES['image']);
} else { ?>
<h2>Upload an Image</h2><br />
  <form method="post" action="file_upload_improved_short.php"  enctype="multipart/form-data">
   <label>Upload file: <input type="file" name="image[]" accept="image/jpeg, image/png, image/gif" multiple /> </label><br />
    <button type="submit" name="Submitted" value="sent">Submit</button>
  </form>
<?php } 
include '../includes/footer-site.php' ?>