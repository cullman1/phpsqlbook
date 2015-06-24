<?php  require_once('../includes/db_config.php');
       if(isset($_FILES['uploader'])) {
           $folder = "../uploads/".$_FILES["uploader"]["name"];
           move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);    
           $ins_media_set = $dbHost->prepare("INSERT INTO media (media_title, file_name, file_type, file_path, file_size, date_uploaded) VALUES (:title,:name,:type, :path, :size, :date)");
           $ins_media_set->bindParam(":title", $_POST['title']);
           $ins_media_set->bindParam(":name",$_FILES['uploader']['name']);
           $ins_media_set->bindParam(":type",$_FILES['uploader']['type']);
           $ins_media_set->bindParam(":path",$folder);
           $ins_media_set->bindParam(":size",$_FILES['uploader']['size']);
           $date = date("Y-m-d H:i:s");
           $ins_media_set->bindParam(":date", $date);
           $ins_media_set->execute();
           if($ins_media_set->errorCode()!=0) {  die("Insert Media Query failed"); }
       }
         $sel_media_set = $dbHost->prepare("select * FROM media  order by media_id desc");
       $sel_media_set->execute();
       while($row = $sel_media_set->fetch()) {  ?>
              <tr>
                <td><?php echo $row['media_id']; ?></td>
                <?php if($row['file_type']=="image/jpeg" || $row['file_type']=="image/png" || $row['file_type']=="image/gif") { ?>
                        <td><img  width=100 src='../uploads/<?php echo $row['file_name']; ?>' alt='<?php echo $row['file_name']; ?>' class='img-thumbnail'></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td><?php echo $row['media_title']; ?></td>
                <td><?php echo $row['file_name']; ?></td>
                <td><?php echo $row['file_type']; ?></td>            
              </tr>          
<?php } ?>


