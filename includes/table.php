<?php  
/* Db Details */
require_once('../includes/db_config.php');

if(isset($_FILES['uploader']))
{
    $folder = "../uploads/".$_FILES["uploader"]["name"];
    $thumbnail = "";
    if(isset($_FILES["uploader"]["thumbnail"]))
    {
        $thumbnail = "../uploads/".$_FILES["uploader"]["thumbnail"];
    }
    move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
              
    /* Query SQL Server for inserting data. */
   $insert_media_sql = "INSERT INTO media (thumbnail, media_title, name, file_type, url, size, date_uploaded) VALUES ('". $thumbnail."','".$_REQUEST['title']."','".$_FILES['uploader']['name']."', '".$_FILES['uploader']['type']."', '".$folder."', '".$_FILES['uploader']['size']."', '". date("Y-m-d H:i:s") ."')";
   $insert_media_result = $dbHost->prepare($insert_media_sql);
   $insert_media_result->execute();
   if($insert_media_result->errorCode()!=0) {  die("Insert Media Query failed"); }
}
else if ((!$_FILES) && isset($_REQUEST["submitted"]))
{
    echo "<br/><br/><span class='red'>File upload failed</span>";
} 

/* Query SQL Server for selecting data. */
$select_media_sql = "select * FROM media";
$select_media_result = $dbHost->prepare($select_media_sql);
$select_media_result->execute();
$select_media_result->setFetchMode(PDO::FETCH_ASSOC);

while($select_media_row = $select_media_result->fetch()) { 

/* Query SQL Server for selecting data. */
$select_medialink_sql = "select * FROM media_link where media_id=".$select_media_row['media_id'];
$select_medialink_result = $dbHost->prepare($select_medialink_sql);
$select_medialink_result->execute();
$select_medialink_result->setFetchMode(PDO::FETCH_ASSOC);
?>
              <tr>
                <td><?php echo $select_media_row['media_id']; ?></td>
                <?php if($select_media_row['file_type']=="image/jpeg" || $select_media_row['file_type']=="image/png" || $select_media_row['file_type']=="image/gif")
                      { ?>
                        <td><a href=""><img  width=100 src='../uploads/<?php echo $select_media_row['file_name']; ?>' alt='<?php echo $select_media_row['file_name']; ?>' class='img-thumbnail'></a></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td><?php while($select_medialink_row = $select_medialink_result->fetch()) { echo $select_medialink_row['article_id'] . " "; } ?></td>
                <td><?php echo $select_media_row['media_title']; ?></td>
                <td><?php echo $select_media_row['file_name']; ?></td>
                <td><?php echo $select_media_row['file_type']; ?></td>
                <td><div name="deletebutton<?php echo $select_media_row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-remove red"></span></div></td>   
              </tr>          
<?php 
} ?>
<input id="media_id" name="media_id" type="hidden"/>
<script src="../js/deletebutton.js" type="text/javascript"></script> 