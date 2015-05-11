<?php require_once('../includes/db_config.php');
      include '../includes/header.php'; ?>
<form method="post" action="file_upload.php" enctype="multipart/form-data">
        <div id="leftcol">
          <h2>Upload an Image</h2>
          <div id="Status_Post">
               <?php          if(isset($_FILES['image_upload'])) {
                   if($_FILES["image_upload"]["name"]!="") { 
                       try {
                           $folder = 'C:\\Temp\\' . $_FILES["image_upload"]["name"];
             if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder)) {
                               throw new Exception('Unable to upload file');
                           }
                       }
                       catch (Exception $ex) {
                           unset($_REQUEST['Submitted']);
   echo "<span class='red' style='color:red;'>".$ex->getMessage()."</span><br/>";
                       }
                   }
               }
               if(isset($_REQUEST['Submitted'])) {
   echo "<span class='red'>Image successfully uploaded!</span><br/>";
               }  ?>
          </div>     
            <label>Upload image:</label>
              <input type="file" id="image_upload" name="image_upload" />
<input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn" />
              <input id="Submitted" name="Submitted" type="hidden" value="true"/>
      </div>
    </form>
<?php include '../includes/footer-editor.php' ?>