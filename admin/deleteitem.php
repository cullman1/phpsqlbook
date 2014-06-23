
<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query */
$tsql = 'delete FROM 387732_phpbook1.media where media_id='.$_REQUEST["media_id"];
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

/* Query SQL Server for selecting data. */
$tsql2 = "select * FROM media";
$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

while($row = mysql_fetch_array($stmt2)) 
	{ ?>
              <tr>
                <td><?php echo $row['media_id']; ?></td>
                <?php if($row['file_type']=="image/jpeg")
                      { ?>
                        <td><a href=""><img  width=100 src='../uploads/<?php echo $row['name']; ?>' alt='<?php echo $row['name']; ?>' class='img-thumbnail'></a></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td></td>
                <td><?php echo $row['media_title']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['file_type']; ?></td>
                <td><div name="deletebutton<?php echo $row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-remove red"></span></div></td>
              </tr>
<?php } ?>
<input id="media_id" name="media_id" type="hidden"/>

<script src="../js/deletebutton.js" type="text/javascript"></script>