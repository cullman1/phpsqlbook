<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting article and associated media. */
$select_article_sql = "SELECT title, content, article.article_id,  category_id, parent_id, featured_media_id FROM article where article.article_id=".$_REQUEST['article_id'];
$select_article_result = $dbHost->prepare($select_article_sql);
$select_article_result->execute();
$select_article_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM category";
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting parent. */
$select_parent_sql = "select parent_id, parent_name FROM parent";
$select_parent_result = $dbHost->prepare($select_parent_sql);
$select_parent_result->execute();
$select_parent_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server linking media to article via media link table. */
$select_medialink_sql = "select * FROM media_link JOIN 387732_phpbook1.media ON media.media_id = media_link.media_id where media_link.article_id=".$_REQUEST['article_id'];
$select_medialink_result = $dbHost->prepare($select_medialink_sql);
$select_medialink_result->execute();
$select_medialink_result->setFetchMode(PDO::FETCH_ASSOC);

/* Postback */
if (isset($_REQUEST['Submitted']))
{
    /* Update contents of article table */
    $update_article_sql = "UPDATE 387732_phpbook1.article SET title= '" .$_REQUEST["ArticleTitle"]."', content='" .$_REQUEST["ArticleContent"]. "', category_id=" .$_REQUEST["CategoryId"]. ", parent_id=" .$_REQUEST["PageId"]. " where article_id=".$_REQUEST["article_id"];
    $update_article_result = $dbHost->prepare($update_article_sql);
    $update_article_result->execute();
    if($update_article_result->errorCode()!=0) {  die("Delete Media Query failed"); }
    else
    {
        if(isset($_FILES['document_upload']))
        {
            if($_FILES["document_upload"]["name"]!="")
            {
                $folder = "../uploads/".$_FILES["document_upload"]["name"];
                move_uploaded_file($_FILES['document_upload']['tmp_name'], $folder);
                
                /* Query SQL Server for inserting media. */
                $insert_media_sql = "INSERT INTO media (media_title, name, file_type, url, size, date_uploaded) VALUES ('".$_FILES["document_upload"]["name"]."','".$_FILES['document_upload']['name']."', '".$_FILES['document_upload']['type']."', '".$folder."', '".$_FILES['document_upload']['size']."', '". date("Y-m-d H:i:s") ."')";
                $insert_media_result = $dbHost->prepare($insert_media_sql);
                $insert_media_result->execute();
                if($insert_media_result->errorCode()!=0) {  die("Insert Media Query failed"); }

                /* Query SQL Server for inserting media link into link table. */
                $insert_medialink_sql = "INSERT media_link (article_id, media_id) VALUES  (".$_REQUEST["article_id"].",".$dbHost->lastInsertId().")";
                $insert_medialink_result = $dbHost->prepare($insert_medialink_sql);
                $insert_medialink_result->execute();
                if($insert_medialink_result->errorCode()!=0) {  die("Insert Media LinkQuery failed"); }
            }
        }

        if($_REQUEST['fimagehidden']!="")
        {
            $update_media_sql = "UPDATE 387732_phpbook1.media SET article_id =".$_REQUEST["article_id"]." where media_id=".$_REQUEST['fimagehidden'];
            $update_media_result = $dbHost->prepare($update_media_sql);
            $update_media_result->execute();
            if($update_media_result->errorCode()!=0) {  die("Update Media Query failed"); }
        }
    }  
}

include '../includes/header.php' ?>
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet"> 
<script type="text/Javascript">
function assigncontent()
{
  var textControl = document.getElementById("rich-text-container");
  var sHTML = textControl.innerHTML;
  var sHTML2 = $('#ArticleTitle').val();
  $('#ArticleContent').val(sHTML);
  $('#ArticleTitle').val(sHTML2);
}
</script>

<div id="body">
  <form id="form1" method="post" action="edit-article.php" onsubmit="assigncontent()" enctype="multipart/form-data">
    <?php while($select_article_row = $select_article_result->fetch()) { ?>
      <div>
      
          <h2>Edit an Article</h2>   
          <div id="Status" >
              <?php 
              if(isset($_REQUEST['Submitted']))
                {
                  echo "<span class='red' style='color:red'>Article successfully edited</span>";
                }
              ?>
            </div>
            <br />
            <label>Title: <input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php echo $select_article_row['title']; ?>"/></label>
            <label><?php include '../includes/rich-text-control.php' ?></label>
            <label>Featured Image:  <?php 
              if (isset($_REQUEST['img_choose']))  {
                  
                  
                  echo "<span>../uploads/".$_REQUEST['img_choose']."</span>";
                  $update_media_sql = "SELECT * FROM media where file_name LIKE '".$_REQUEST['img_choose']."'";
                  
                  $update_media_result = $dbHost->prepare($update_media_sql);
                  $update_media_result->execute();
                  $update_media_result->setFetchMode(PDO::FETCH_ASSOC);
                  while ($row = $update_media_result->fetch()) {
                      echo "<input name='featured_image' type=hidden value='".$row["media_id"]."' />";
                  }
              } 
              else {
                  
                  if($select_article_row["featured_media_id"]!=0) {
                      
                      echo "<input name='featured_image' type=hidden value='".$select_article_row["featured_media_id"]."' />";
                  } else {
                      echo "<input name='featured_image' type=hidden value='0' />";
                  }
              }
              
              if ((!empty( $select_article_row["featured_media_id"])) || (!empty($select_article_row["file_name"])) ) {   
                  echo "<span>../uploads/". $select_article_row["file_name"]."</span>";
              } ?>
                  <br />
                   <a class="btn" href="../admin/featured-image.php?featured=edit&article_id=<?php echo $select_article_row["article_id"]; ?>">Add Featured Image</a> </label>
                
                <label>Associated Docs:  <?php while($select_medialink_row = $select_medialink_result->fetch()) 
                  {
                      if (isset($select_medialink_row['name']) && ($select_medialink_row['file_type']!="image/jpeg" && $select_medialink_row['file_type']!="image/png"))
                    { 
                        echo $select_medialink_row['name'] ." - " . "<span name='deletebutton".$select_medialink_row['media_id']."' class='glyphicon glyphicon-remove red deleter'></span></div><br/>"; 
                          echo "<input type='hidden' id='fdochidden". $select_medialink_row['media_id']."' name='fdochidden". $select_medialink_row['media_id']."' value='' />"; 
                    } 
                  }
                  ?> 
                </label>
              <label>Category:&nbsp;    <select id="CategoryId" name="CategoryId">     
                    <?php while($select_category_row = $select_category_result->fetch()) { ?>
                    <option value="<?php  echo $select_category_row['category_id']; ?>"<?php if( $select_category_row['category_id'] == $select_article_row['category_id']) { echo "selected";} ?> ><?php  echo $select_category_row['category_name']; ?></option>
                    <?php } ?> 
                  </select></label>
              
              <label>Parent Page:&nbsp; <select id="PageId" name="PageId">
                    <?php while($select_parent_row = $select_parent_result->fetch()) { ?>
                    <option value="<?php  echo $select_parent_row['parent_id']; ?>"  <?php if( $select_parent_row['parent_id'] == $select_article_row['parent_id']) { echo "selected";} ?>><?php  echo $select_parent_row['parent_name']; ?></option>
                    <?php } ?> 
                  </select></label>
                 <br />
           
                    <input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn btn-primary" />
                     <input id="ArticleContent" name="ArticleContent" type="hidden" value=""/>
               
          <br />
          <a id="Return2" href="pages.php">Return to Main Page</a>
          <input id="article_id" name="article_id" type="hidden" value="<?php echo $_REQUEST['article_id'];?>"/>
             <input id="Submitted" name="Submitted" type="hidden" value="true"/>
        </div>
      <?php } ?>         
    </form><!--end content --> 
  </div>
<div class="clear"></div>
<script src="../js/deletebutton.js" type="text/javascript"></script>
<?php include '../includes/footer-editor.php' ?>