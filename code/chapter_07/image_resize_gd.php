<?php
ini_set('display_errors', TRUE);
 function file_upload($file) {
$copied_image="";
$resized_image="";   
foreach($file['tmp_name'] as $key =>$tmp_name) {
   $type=  $file["type"][$key];
   if((( $type!= "image/jpeg") && ( $type!="image/png") && ( $type[$key]!="image/gif")) || ($file["size"][$key]>10000000)) {
      echo 'Illegal file type or size uploaded';
    } else if ($file['tmp_name'][$key] == "") {
      echo 'Your image did not upload.';
    } else {
      $filename = $file['name'][$key];
      if(move_uploaded_file($file['tmp_name'][$key],"../uploads/". $filename)) {
      $copied_image = copy_image($filename);
      $resized_image = resize_image($copied_image, 50, 50);
         echo 'Your file ' . $filename. ' has uploaded successfully.<br/>';
          echo "<img src='".$resized_image."' />";
      } else {
         echo 'Your image '. $filename .' could not be saved.<br/>';
      }
    }
  }
} 
function copy_image($file) {
$filename = "../uploads/".$file;
  $copied_image = "";
 $file_type = exif_imagetype($filename);
  switch($file_type) {
    case 1: //exif values - 1-gif
     $copied_image= "../uploads/"."copy.gif";
     $img = imageCreateFromGif($filename);
     imagegif($img, $copied_image);
      break;
   case 2: //exif values -  2-jpg
      $copied_image= "../uploads/"."copy.jpg";
      $img = imageCreateFromJpeg($filename);
      imagejpeg($img, $copied_image);
      break;
    case 3: //exif values -  3 - png
      $copied_image= "../uploads/"."copy.png";
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
    imagecopyresampled($img_id,$src,0,0,0,0,$newwidth,$newheight,$width_orig, $height_orig);
     imagegif($img_id, "../uploads/".$filename."_thumbnail.gif");
      return "../uploads/".$filename."_thumbnail.gif";
  case 2:
      $src = imagecreatefromjpeg($filename);
      $img_id = imagecreatetruecolor($newwidth, $newheight);
      imagecopyresampled($img_id,$src,0,0,0,0,$newwidth, $newheight, $width_orig, $height_orig);
      imagejpeg($img_id, "../uploads/".$filename."_thumbnail.jpg");
      return "../uploads/".$filename."_thumbnail.jpg";
    case 3:
      $src = imagecreatefrompng($filename);
      $img_id = imagecreatetruecolor($newwidth, $newheight);
      imagecopyresampled($img_id,$src,0,0,0,0,$newwidth,$newheight,$width_orig, $height_orig);
      imagepng($img_id, "../uploads/".$filename."_thumbnail.png");
      return "../uploads/".$filename."_thumbnail.png";
  }
  return "";
}
if(isset($_FILES['image'])) {
  file_upload($_FILES['image']);
} else { ?>
<h2>Upload an Image</h2><br />
  <form method="post" action="image_resize_gd.php"  enctype="multipart/form-data">
   <label>Upload file: <input type="file" name="image[]"  
     accept="image/jpeg, image/png, image/gif" multiple /> </label><br />
    <button type="submit" name="Submitted" value="sent">Submit</button>
  </form>
<?php } ?>