<?php 
/* Login check */
require_once('authenticate.php'); 

/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM 387732_phpbook1.category";
$select_category_result = $dbHost->query($select_category_sql);
# setting the fetch mode
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting parent page. */
$select_parent_sql = "select parent_id, parent_name FROM 387732_phpbook1.parent";
$select_parent_result = $dbHost->query($select_parent_sql);
# setting the fetch mode
$select_parent_result->setFetchMode(PDO::FETCH_ASSOC);

/* Postback */
if (isset($_REQUEST['Submitted']))
{
    /* Query SQL Server for inserting article. */
    $insert_article_sql = "INSERT INTO article (title, content, date_posted, category_id, parent_id, user_id) VALUES ('".$_REQUEST['ArticleTitle']."', '".$_REQUEST['ArticleContent']."',  '". date("Y-m-d H:i:s") ."', '".$_REQUEST['CategoryId']."', '".$_REQUEST['PageId']."', '".$_SESSION['authenticated']."')";
    $insert_article_result = $dbHost->prepare($insert_article_sql);
    $insert_article_result->execute();
    $newarticleid = $dbHost->lastInsertId();
    if($insert_article_result->errorInfo()[1]!=0) {  die("Insert Article Query failed: ".$insert_article_result->errorInfo()[0]); }
    else
    {
        $articleid = "0";
        if(isset($_REQUEST['article_id']))
        {
            $articleid = $_REQUEST['article_id'];
        }
        else
        {
            $articleid = $dbHost->lastInsertId();
        }
        
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
                if($insert_media_result->errorInfo()[1]!=0) {  die("Insert Media Query failed: ".$insert_media_result->errorInfo()[0]); }
                $newmediaid = $dbHost->lastInsertId();

                /* Query SQL Server for inserting media link. */
                $insert_medialink_sql = "INSERT INTO media_link (article_id, media_id) VALUES (".$newarticleid.", '".$newmediaid."')";
                $insert_medialink_result = $dbHost->prepare($insert_medialink_sql);
                $insert_medialink_result->execute();
                if($insert_medialink_result->errorInfo()[1]!=0) {  die("Insert Media Link Query failed: ".$insert_medialink_result->errorInfo()[0]); }
            }
        }

        if(isset($_REQUEST['fimagehidden']))
        {
            /* Query SQL Server for updaing media. */
            $update_media_sql = "UPDATE media set article_id =".$articleid." where media_id=".$_REQUEST['fimagehidden'];
            $update_media_result = $dbHost->prepare($update_media_sql);
            $update_media_result->execute();
            if($update_media_result->errorInfo()[1]!=0) {  die("Update Media Query failed: ".$update_media_result->errorInfo()[0]); }
        }
    }
}

/* Add header */
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
    <form id="galleryform" method="post" action="add-article.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add an Article</h2><br />
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
                    <?php include '../includes/rich-text-control.php' ?>
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
                <td style="vertical-align:top;"><span class="fieldheading">Parent Page:&nbsp;</span></td>
                <td>   
                    <select id="PageId" name="PageId">
                        <?php while($select_parent_row = $select_parent_result->fetch()) { ?>
                        <option value="<?php  echo $select_parent_row['parent_id']; ?>"><?php  echo $select_parent_row['parent_name']; ?></option>
                        <?php } ?> 
                    </select>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Featured Image:</td>
              <td>
                <?php include '../includes/gallery-modal.php' ?> <?php if (isset($_REQUEST["imgname"])){ echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; } if(isset($_REQUEST["pressed"])){ echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='".$_REQUEST["pressed"]."' />"; }?>
              </td>         
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>Add associated documents/pdfs:</td>
                <td>
                    <input type="file" id="document_upload" name="document_upload"> 
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
      <br />
      <a id="Return2" href="../admin/pages.php">Return to Main Page</a>
      </div>
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>
