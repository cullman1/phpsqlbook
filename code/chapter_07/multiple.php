<form action="multiple.php" method="post" enctype="multipart/form-data">
  <h2>Upload files</h2><br />
  <input name="files[]" type="file" multiple /> <br /><br />
  <input type="submit" value="Upload files" />
</form>
<?php if (isset($_FILES["files"])) {
 foreach($_FILES['files']['tmp_name'] as $key =>$tmp_name){
   $name = $_FILES['files']['name'][$key];
   $size =$_FILES['files']['size'][$key];
   $type=$_FILES['files']['type'][$key];
   move_uploaded_file($_FILES['files']['tmp_name'][$key],      '../uploads/'.$_FILES['files']['name'][$key]);
   echo  $name . " - " .$size . " - ". $type ." uploaded  <br/>"; 
  }
} ?>