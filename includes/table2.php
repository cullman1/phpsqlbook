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
             
                <?php if(($row['file_type']=="image/jpeg") || ($row['file_type']=="image/png"))
                      { ?>
                        <td><a href=""><img  width=200 src='../uploads/<?php echo $row['name']; ?>' alt='<?php echo $row['name']; ?>' class='img-thumbnail'></a></td>
               <?php  } ?>
                <td><a href="" name="selectbutton<?php echo $row['media_id']; ?>" class="deleter"><span class="glyphicon glyphicon-ok"></span></a></td>   
              </tr>

              
<?php 
} ?>
<input id="media_id" name="media_id" type="hidden"/>


 