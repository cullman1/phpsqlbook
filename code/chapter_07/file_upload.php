<?php       include '../includes/header-register.php' ?>
    <div id="Status_Post">
    <?php
      if(!isset($_FILES['image_upload'])) {
    ?>
    <h2 style="margin-left:10px">Upload an Image</h2><br />
    <form  class="indent" method="post" action="file_upload.php"  enctype="multipart/form-data">
        <label>File to upload:</label>
        <input type="file" name="image_upload" /> 
        <button type="submit" class="button_block spacing btn btn-primary">Submit</button>
        <input id="Submitted" name="Submitted" type="hidden" value="true"/>
    </form>
    <?php 
      } else {
      if($_FILES["image_upload"]["name"]!="") {
          try {
              $folder = "../uploads/".$_FILES["image_upload"]["name"];
              if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder)) {
                  throw new Exception('Unable to move file');
              } 
          }
          catch (Exception $ex) {
              unset($_POST['Submitted']);
              echo "<span class='red'>".$ex->getMessage()."</span>";
          }
          if(isset($_POST['Submitted'])) {
              echo "<span class='red'>Image successfully uploaded!</span>";
          }
      }
    }
    ?>
    </div>
<?php include '../includes/footer-site.php' ?>  
