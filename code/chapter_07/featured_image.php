<?php require_once('../includes/db_config.php');
 function get_media($dbHost) {
  $sql = "select * FROM media";
  $statement = $dbHost->prepare($sql);
  $statement->execute();
  return $statement;
 }
 if(isset($_GET['featured'])) {
  $statement = get_media($dbHost);  ?>
  <form method="post" action="<?php echo $_GET['featured'];?>-article.php<?php if ($_GET["featured"]=="edit"){ echo "?article_id=".$_GET['article_id']; } ?>">
  <div class="image_wall">
  <?php while ($row = $statement->fetch()) { 
   echo  '<div><img src="../uploads/'.$row["file_name"]. '" /><br/>   <label>Make Featured Image<input type="radio" name="image" value="'.$row["file_name"].'"/> <input type="hidden" name="media_id" value="'.$row["media_id"].'" /></label></div>';
      } ?>   
    </div>
  <input type="submit" value="Submit Choice of Image" />    
  </form>  
<?php  } ?>