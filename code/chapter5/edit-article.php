<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting article and associated media. */
$select_article_sql = "SELECT title, content, article.article_id,  category_id, parent_id FROM article where article.article_id=".$_REQUEST['article_id'];
$select_article_result = $dbHost->prepare($select_article_sql);
$select_article_result->execute();
$select_article_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM 387732_phpbook1.category";
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

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

    }  

}

if(isset($_FILES['image_upload']))
{
    if($_FILES["image_upload"]["name"]!="")
    {
        $folder = "../uploads/".$_FILES["image_upload"]["name"];
        move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder);
        
        /* Query SQL Server for inserting media. */
        $insert_media_sql = "INSERT INTO media (media_title, name, file_type, url, size, date_uploaded) VALUES ('".$_FILES["image_upload"]["name"]."','".$_FILES['image_upload']['name']."', '".$_FILES['document_upload']['type']."', '".$folder."', '".$_FILES['document_upload']['size']."', '". date("Y-m-d H:i:s") ."')";
        $insert_media_result = $dbHost->prepare($insert_media_sql);
        $insert_media_result->execute();
        
        if($insert_media_result->errorCode() != 0) {  die("Insert Media Query failed: "); }
        $newmediaid = $dbHost->lastInsertId();

        /* Query SQL Server for inserting media link. */
        $insert_medialink_sql = "INSERT INTO media_link (article_id, media_id) VALUES (".$newarticleid.", '".$newmediaid."')";
        $insert_medialink_result = $dbHost->prepare($insert_medialink_sql);
        $insert_medialink_result->execute();
        if($insert_medialink_result->errorCode() != 0) {  die("Insert Media Link Query failed: "); }
    }
}

/* Add header */
include '../includes/header.php' ?>
 <script type="text/Javascript">
     function assigncontent() {
         $('#ArticleContent').val(document.getElementById("rich-text-container").innerHTML);
     }
</script>

<div id="body">
    <form id="galleryform" method="post" action="edit-article.php" onsubmit="assigncontent()" enctype="multipart/form-data">
         <?php while($select_article_row = $select_article_result->fetch()) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit an Article</h2><br />
          <div id="Status_Post">
               <?php 
               if(isset($_REQUEST['Submitted']))
               {
                   echo "<span class='red' style='color:red;'>Article successfully created!</span><br/>";
               }  
               ?>
          </div>
            <br/>
          <table>
            <tr>
		        <td><span class="fieldheading">Title:</span></td>
				<td><input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php if (isset($_REQUEST["ArticleTitle"])){ echo $_REQUEST["ArticleTitle"]; }?>" /></td> 
			</tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
		        <td style="vertical-align:top;"><span class="fieldheading">Content:&nbsp;</span></td>
				<td>     
                                 <textarea class="contentbox"><?php echo $select_article_row['content']; ?>"/></textarea>
                </td> 
			</tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>
                  <select id="CategoryId" name="CategoryId">
                            <?php while($select_category_row = $select_category_result->fetch()) { ?>
                     <option value="<?php  echo $select_category_row['category_id']; ?>"><?php  echo $select_category_row['category_name']; ?></option>
                     <?php } ?> 

                  </select>
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
          <tr>
                <td>Alter featured image:</td>
<td>
<img src="<?php  echo $select_category_row['media']; ?>" />
                </td>
                <td>
                    <input type="file" id="image_upload" name="image_upload"> 
                </td>
            </tr>

     
            <tr><td>&nbsp;</td></tr>    
            <tr>
				<td></td>
				<td>
                    <input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn btn-primary" />
				</td>
                <input id="ArticleContent" name="ArticleContent" type="hidden" />
                  <input id="Submitted" name="Submitted" type="hidden" value="true"/>
			 </tr> 
          </table>
          <br />
          <br />  
      </div>
      </div>
            <?php } ?>     
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>