<?php require_once ('../includes/header-register.php'); ?>
    <div id="Status_Post">
    <?php
      if(!isset($_FILES['image_upload'])) {
    ?>
    <h2 style="margin-left:10px">Upload an Image</h2><br />
    <form class="indent" method="post" action="file_upload_improved.php" enctype="multipart/form-data">      
        <label>File to upload:</label>
        <input type="file" id="image_upload" name="image_upload" accept="image/jpeg, image/png, image/gif" /> 
        <button type="submit" class="button_block spacing btn btn-primary">Submit</button>
        <input id="Submitted" name="Submitted" type="hidden" value="true"/>
    </form>
    <?php 
    } else {
    if($_FILES["image_upload"]["name"]!="") {
        try {
                $folder = "../uploads/".$_FILES["image_upload"]["name"];
                if (($_FILES["image_upload"]["type"] != "image/jpeg") && ($_FILES["image_upload"]["type"] != "image/png") && ($_FILES["image_upload"]["type"] != "image/gif"))  {                            
                    throw new Exception('Illegal file type');
                }
                if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder)) {
                    throw new Exception('Unable to upload file');
                }
            }
            catch (Exception $ex) {
                unset($_REQUEST['Submitted']);
                echo "<span style='color:red;'>".$ex->getMessage()."</span><br/>";
            }
            if(isset($_REQUEST['Submitted'])) {
                echo "<span class='red' style='color:red;'>Image successfully uploaded!</span><br/>";
            } 
        }      
    }    
?>
</div>
<?php include '../includes/footer-site.php' ?>