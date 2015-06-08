<form action="multiple.php" method="post" enctype="multipart/form-data">
  Send these files:<br />
  <input name="multi_files[]" type="file" multiple /><br />
  <input type="submit" value="Send files" />
</form>
<?php if (isset($_FILES["files"]))
{
    $count = 0;
    foreach($_FILES['multi_files']['tmp_name'] as $key => $tmp_name ){
        $name = $_FILES['multi_files']['name'][$key];
        $size =$_FILES['multi_files']['size'][$key];
        $tmp =$_FILES['multi_files']['tmp_name'][$key];
        $type=$_FILES['multi_files']['type'][$key];
        echo  $file_name . "<br/>"; 
    }
} 
?>