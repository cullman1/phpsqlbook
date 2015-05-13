<?php 
require_once('../includes/db_config.php');
include '../includes/header.php';
         
 function copy_image($filename) {
                   $copied_image = "";
                   $file_type = exif_imagetype($filename);
                   switch($file_type) {
                       case 1: //exif values - 1-gif
                           $copied_image= "../uploads/copy.gif";
                           $img = imageCreateFromGif($filename);
                           imagegif($img, $copied_image);
                           break;
                       case 2: //exif values -  2-jpg
                           $copied_image= "../uploads/copy.jpg";
                           $img = imageCreateFromJpeg($filename);
                           imagejpeg($img, $copied_image);
                           break;
                       case 3: //exif values -  3 - png
                           $copied_image= "../uploads/copy.png";
                           $img = imageCreateFromPng($filename);
                           imagepng($img, $copied_image);
                           break;
                   }
                   return $copied_image;
               }

               function resize_image($filename, $width_resize, $height_resize) {
                   $file_type = exif_imagetype($filename); //exif values - 1-gif, 2-jpg,3 - png
                   list($width_orig, $height_orig) = getimagesize($filename);
                   $ratio = $width_orig / $height_orig;      
                   if ($width_resize /$height_resize > $ratio) {
                       $newwidth = $height_resize *$ratio;
                       $newheight = $height_resize;
                   } else {
                       $newheight = $width_resize /$ratio;
                       $newwidth = $width_resize;
                   }
                   switch($file_type) {
                       case 1:
                           $src = imagecreatefromgif($filename);
                           $img_id = imagecreatetruecolor($newwidth, $newheight);
                           imagecopyresampled($img_id,$src,0,0,0,0,$newwidth,$newheight,$width_orig,$height_orig);
                           imagegif($img_id, "../uploads/thumbnail.gif");
                           return "../uploads/thumbnail.gif";
                       case 2:
                           $src = imagecreatefromjpeg($filename);
                           $img_id = imagecreatetruecolor($newwidth, $newheight);
                           imagecopyresampled($img_id,$src,0,0,0,0,$newwidth, $newheight, $width_orig, $height_orig);
                           imagejpeg($img_id, "../uploads/thumbnail.jpg");
                           return "../uploads/thumbnail.jpg";
                       case 3:
                           $src = imagecreatefrompng($filename);
                           $img_id = imagecreatetruecolor($newwidth, $newheight);
                           imagecopyresampled($img_id,$src,0,0,0,0, $newwidth, $newheight, $width_orig, $height_orig);
                           imagepng($img_id, "../uploads/thumbnail.png");
                           return "../uploads/thumbnail.png";
                   }
                   return "";
               }  ?>
     <?php    if(isset($_FILES['image_upload']))  { ?>
          <div id="Status_Post">
               <h2>Upload an Image</h2><br />
               <?php  $copied_image="";
                      $resized_image="";    
                       if($_FILES["image_upload"]["name"]!="") {
                        try {
                         $folder = "../uploads/".$_FILES["image_upload"]["name"];
                          if (($_FILES["image_upload"]["type"] != "image/jpeg") && ($_FILES["image_upload"]["type"] != "image/png") && ($_FILES["image_upload"]["type"] != "image/gif"))  {
                               throw new Exception('Illegal file type');
                           }
                           if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder)) {
                               throw new Exception('Unable to upload file');
                           }
                           $copied_image = copy_image($folder);
                           $resized_image = resize_image($copied_image, 50, 50);
                       }
                       catch (Exception $ex) {
                           unset($_POST['Submitted']);
                           echo "<span class='red'>".$ex->getMessage()."</span><br/>";
                       }
                        if(isset($_POST['Submitted'])) {
                            echo "<span class='red'>Image successfully uploaded!</span><br/>";
                            echo "<img src='".$resized_image."' />";
                        }
                   }
              } else { ?>
         <form  class="indent" method="post" action="image_resizer.php"  enctype="multipart/form-data">
        <label>File to upload:</label>
        <input type="file" name="image_upload" /> 
        <button type="submit" class="button_block spacing btn btn-primary">Submit</button>
        <input id="Submitted" name="Submitted" type="hidden" value="true"/>
    </form>
<?php } ?>
<?php include '../includes/footer-editor.php' ?>