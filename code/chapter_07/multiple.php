<?php 
 function files_upload($files) {
 foreach($files['tmp_name'] as $key =>$tmp_name){
   $name =$files['name'][$key];
   $size =$files['size'][$key];
   $type=$files['type'][$key];
   move_uploaded_file($files['tmp_name'][$key],      '../uploads/'.$files['name'][$key]);
   echo  $name . " - " .$size . " - ". $type ." uploaded  <br/>"; 
  }
 }
if (isset($_FILES["files"])) {
files_upload($_FILES["files"]);
} else { ?>
<form action="multiple.php" method="post" enctype="multipart/form-data">
  <h2>Upload files</h2><br />
  <input name="files[]" type="file" multiple /> <br /><br />
  <input type="submit" value="Upload files" />
</form>
<?php } ?>