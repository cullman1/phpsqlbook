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
   $insert_media_result = $dbHost->query($insert_media_sql);
   if(!$insert_media_result) {       die("Query failed: ". mysql_error()); }
}
else if ((!$_FILES) && isset($_REQUEST["submitted"]))
{
    echo "<br/><br/><span class='red'>File upload failed</span>";
} 

/* Query SQL Server for selecting data. */
$select_media_sql = "select * FROM media";
$select_media_result = $dbHost->query($select_media_sql);
# setting the fetch mode
$select_media_result->setFetchMode(PDO::FETCH_ASSOC);

while($select_media_row = mysql_fetch_array($select_media_result)) { 

/* Query SQL Server for selecting data. */
$select_medialink_sql = "select * FROM media_link where media_id=".$select_media_row['media_id'];
$select_medialink_result = $dbHost->query($select_medialink_sql);
# setting the fetch mode
$select_medialink_result->setFetchMode(PDO::FETCH_ASSOC);
?>
              <tr>
                <td><?php echo $select_media_row['media_id']; ?></td>
                <?php if($select_media_row['file_type']=="image/jpeg" || $select_media_row['file_type']=="image/png" || $select_media_row['file_type']=="image/gif")
                      { ?>
                        <td><a href=""><img  width=100 src='../uploads/<?php echo $select_media_row['name']; ?>' alt='<?php echo $select_media_row['name']; ?>' class='img-thumbnail'></a></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td><?php while($select_medialink_row = mysql_fetch_array($select_medialink_result)) { echo $select_medialink_row['article_id'] . " "; } ?></td>
                <td><?php echo $select_media_row['media_title']; ?></td>
                <td><?php echo $select_media_row['name']; ?></td>
                <td><?php echo $select_media_row['file_type']; ?></td>
                <td><div name="deletebutton<?php echo $select_media_row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-remove red"></span></div></td>   
              </tr>          
<?php 
} ?>
<input id="media_id" name="media_id" type="hidden"/>
<script src="../js/deletebutton.js" type="text/javascript"></script>

 