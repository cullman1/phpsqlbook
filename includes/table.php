<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Include passwords and login details */
require_once('../includes/loginvariables.php');
  
/* Connect using MySql Authentication. */
$conn = mysql_connect( $serverName, $userName, $password);
if(!$conn)
{
        die("Unable to connect. Error: " . mysql_error());
}
  
/* Select db */
mysql_select_db($databaseName) or die ("Couldn't select db. Error:"  . mysql_error()); 

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
    $tsql2 = "INSERT INTO media (thumbnail, media_title, name, file_type, url, size, date_uploaded) VALUES ('". $thumbnail."','".$_REQUEST['title']."','".$_FILES['uploader']['name']."', '".$_FILES['uploader']['type']."', '".$folder."', '".$_FILES['uploader']['size']."', '". date("Y-m-d H:i:s") ."')";
    $stmt2 = mysql_query($tsql2);
    if(!$stmt2)
    {  
        /* Error Message */
      die("Query failed: ". mysql_error());
    }

}
else if ((!$_FILES) && isset($_REQUEST["submitted"]))
{
    echo "<br/><br/><span class='red'>File upload failed</span>";
} 

/* Query SQL Server for selecting data. */
$tsql = "select * FROM media";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}



while($row = mysql_fetch_array($stmt)) { 

/* Query SQL Server for selecting data. */
$tsql2 = "select * FROM media_link where media_id=".$row['media_id'];
$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
    ?>
              <tr>
                <td><?php echo $row['media_id']; ?></td>
                <?php if($row['file_type']=="image/jpeg" || $row['file_type']=="image/png")
                      { ?>
                        <td><a href=""><img  width=100 src='../uploads/<?php echo $row['name']; ?>' alt='<?php echo $row['name']; ?>' class='img-thumbnail'></a></td>
               <?php  } else { ?>
                        <td>-</td>
               <?php  } ?>
                <td><?php while($row2 = mysql_fetch_array($stmt2)) { echo $row2['article_id'] . " "; } ?></td>
                <td><?php echo $row['media_title']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['file_type']; ?></td>
                <td><div name="deletebutton<?php echo $row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-remove red"></span></div></td>   
              </tr>

              
<?php 
} ?>
<input id="media_id" name="media_id" type="hidden"/>
<script src="../js/deletebutton.js" type="text/javascript"></script>

 