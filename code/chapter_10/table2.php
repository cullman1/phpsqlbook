<?php  require_once('../includes/db_config.php'); ?>
       <table class="table table-hover">
          <tr>
            <td>Id</td><td>Thumbnail</td><td>Title</td><td>File name</td><td>File type</td>
          </tr>
   <?php if(isset($_FILES['uploader'])) {
           $folder = "../uploads/".$_FILES["uploader"]["name"];
           if(isset($_FILES["uploader"]["thumbnail"])) {
               $thumbnail = "../uploads/".$_FILES["uploader"]["thumbnail"];
           }
           move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);    
           $ins_media_set = $dbHost->prepare("INSERT INTO media (thumbnail, media_title, name, file_type, url, size, date_uploaded) VALUES (:thumbnail,:title,:name,:type, :size; :date)");
           $ins_media_set->bindParam(":thumbnail", $thumbnail);
           $ins_media_set->bindParam(":title", $_POST['title']);
           $ins_media_set->bindParam(":name",$_FILES['uploader']['name']);
           $ins_media_set->bindParam(":type", $folder);
           $ins_media_set->bindParam(":size",  $_FILES['uploader']['size']);
                $date = date("Y-m-d H:i:s");
                $insert_media_result->bindParam(":date", $date);
                $ins_media_set->execute();
                if($ins_media_set->errorCode()!=0) {  die("Insert Media Query failed"); }
       }
       $sel_media_set = $dbHost->prepare("select * FROM media");
       $sel_media_set->execute();
       while($row = $sel_media_set->fetch()) {  ?>
              <tr>
                <td><?php echo $select_media_row['media_id']; ?></td>
                <?php if($row['file_type']=="image/jpeg" || $row['file_type']=="image/png" || $row['file_type']=="image/gif") { ?>
                        <td><img  width=100 src='../uploads/<?php echo $row['name']; ?>' alt='<?php echo $row['name']; ?>' class='img-thumbnail'></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td><?php echo $row['media_title']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['file_type']; ?></td>            
              </tr>          
<?php } ?>
</table>

