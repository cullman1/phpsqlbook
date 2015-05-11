<?php       include '../includes/header-register.php' ?>
   <form  class="indent" method="post" action="file_upload.php"  enctype="multipart/form-data">
     <div class="col-md-4">
       <h2>Upload an Image</h2><br />
       <label>File to upload:</label>
       <input type="file" name="image_upload" /> 
        <button type="submit" class="button_block spacing btn btn-primary">Submit</button>
        <input id="Submitted" name="Submitted" type="hidden" value="true"/>
      </div>
   </form>
      <div id="Status_Post">
       <?php if(isset($_FILES['image_upload'])) {
                 if($_FILES["image_upload"]["name"]!="") {
                     try {
                         $folder = "../uploads/".$_FILES["image_upload"]["name"];
                         if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder)) {
                             throw new Exception('Unable to move file');
                         }
                     }
                     catch (Exception $ex) {
                         unset($_REQUEST['Submitted']);
                     }
                 }
             }
             if(isset($_REQUEST['Submitted'])) {
                 echo "<span class='red'>Image successfully uploaded!</span>";
             } ?>
        </div>
   
<?php include '../includes/footer-site.php' ?>