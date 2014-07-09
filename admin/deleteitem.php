<?php 
 
/* Db Details */
require_once('../includes/db_config.php');

/* Query to delete item from media */
$delete_media_sql = 'delete FROM media where media_id='.$_REQUEST["media_id"];
$delete_media_result = mysql_query($delete_media_sql);
if(!$delete_media_result) {   die("Query failed: ". mysql_error()); }

/* Query SQL Server for selecting data. */
$select_media_sql = "select * FROM media";
$select_media_result = mysql_query($select_media_sql);
if(!$select_media_result) { die("Query failed: ". mysql_error()); }

while($select_media_row = mysql_fetch_array($select_media_result)) 
	{ ?>
              <tr>
                <td><?php echo $select_media_row['media_id']; ?></td>
                <?php if($select_media_row['file_type']=="image/jpeg" || $select_media_row['file_type']=="image/png" || $select_media_row['file_type']=="image/gif")
                      { ?>
                        <td><a href="../uploads/<?php echo $select_media_row['name']; ?>"><img  width=100 src='../uploads/<?php echo $select_media_row['name']; ?>' alt='<?php echo $select_media_row['name']; ?>' class='img-thumbnail'></a></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td></td>
                <td><?php echo $select_media_row['media_title']; ?></td>
                <td><?php echo $select_media_row['name']; ?></td>
                <td><?php echo $select_media_row['file_type']; ?></td>
                <td><div name="deletebutton<?php echo $select_media_row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-remove red"></span></div></td>
              </tr>
<?php } ?>
<input id="media_id" name="media_id" type="hidden"/>
<script src="../js/deletebutton.js" type="text/javascript"></script>