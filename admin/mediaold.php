<?php
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
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
?>
<?php include '../includes/header.php' ?>
  <form id="file" name="file" method="post" action="media.php?submitted=true" enctype="multipart/form-data">
      <div class="panel panel-default">
        <div class="panel-body">
          <form role="form">
            <div class="form-group">
              <label for="uploader">Upload new item</label>
              <input type="file" id="uploader" name="uploader">
              <br/>
              <label for="title">Image title:</label>
              <input id="title" name="title" type="text"/> 

            </div>
            <button type="submit" class="btn btn-default">Upload</button>
            <?php
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
              else
              {
                /* Redirect to original page */

                  header('Location:../admin/media.php?submitted=true');
             
              }
            }
            else if ((!$_FILES) && isset($_REQUEST["submitted"]))
            {
               echo "<br/><br/><span class='red'>File upload failed</span>";
            } 
            ?>
          </form>
          <div>
            <?php if (isset($_REQUEST["submitted"]))
            {
                if ($_REQUEST["submitted"]=="true")
                {
                  echo "<br/><br/><span class='red'>File upload succeeded</span>";
                }
            } ?>
          </div>
        </div>
      </div>
    </form>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Thumbnail</th>
             <th>Linked article</th>
             <th>Title</th>
            <th>File name</th>
            <th>File type</th>

            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
            <?php 
          
          while($row = mysql_fetch_array($stmt)) { ?>
          <tr>
               <td><?php echo $row['media_id']; ?></td>
            <?php if($row['file_type']=="image/jpeg")
            { ?>
            <td><a href=""><img  width=100 src='../uploads/<?php echo $row['name']; ?>' alt='<?php echo $row['name']; ?>' class='img-thumbnail'></a></td>
            <?php  } else { ?>
            <td>-</td>
            <?php  } ?>
               <td><?php echo $row['article_id']; ?></td>
             <td><?php echo $row['media_title']; ?></td>
           <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['file_type']; ?></td>

            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item <?php echo $row['media_id'];?>&#39;);" id="delete1" href="deleteitem.php?media_id=<?php echo $row['media_id'];?>".><span class="glyphicon glyphicon-remove red"></span></a></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>
        <div id="Status_Post">
            <?php 
             if(isset($_GET['deleted']))
             {
              echo "<span class='red' style='color:red;'>Item successfully deleted!</span>";
             }  
           ?>
         </div>

<?php include '../includes/footer.php' ?>