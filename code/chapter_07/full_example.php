<?php 
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM 387732_phpbook1.category";
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

/* Postback */
if (isset($_REQUEST['Submitted']))
{
    /* Query SQL Server for inserting article. */
    $insert_article_sql = "INSERT INTO article (title, content, date_posted, category_id, user_id) VALUES ('".$_REQUEST['ArticleTitle']."', '".$_REQUEST['ArticleContent']."',  '". date("Y-m-d H:i:s") ."', '".$_REQUEST['CategoryId']."')";
    $insert_article_result = $dbHost->prepare($insert_article_sql);
    $insert_article_result->execute();
    $newarticleid = $dbHost->lastInsertId();
    


if($insert_article_result->errorCode()!= 0){ die("Insert Article Query failed ");}
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
                
                if($insert_media_result->errorCode() != 0) {  die("Insert Media Query failed: "); }
                $newmediaid = $dbHost->lastInsertId();
                /* Query SQL Server for inserting media link. */
                $insert_medialink_sql = "INSERT INTO media_link (article_id, media_id) VALUES (".$newarticleid.", '".$newmediaid."')";
                $insert_medialink_result = $dbHost->prepare($insert_medialink_sql);
                $insert_medialink_result->execute();
                if($insert_medialink_result->errorCode() != 0) {  die("Insert Media Link Query failed: "); }
            }
        }

    }
}


/* Add header */
include '../includes/header.php' ?> 
<div id="body">
    <form id="galleryform" method="post" action="add-article.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add an Article</h2><br />
          <div id="Status_Post">
               <?php 
               if(isset($_REQUEST['Submitted']))
               {
                   echo "<span class='red' style='color:red;'>Article successfully created!</span><br/>";      }  ?>
          </div>
            <br/>
          <table>
            <tr>
		        <td><span class="fieldheading">Title:</span></td>
				<td><input id="ArticleTitle" name="ArticleTitle" type="text" /></td> 
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
                <td>Add featured image:</td>
                <td>
                                    <?php include '../includes/gallery-modal.php' ?>
                </td>
            </tr>
              <tr><td>&nbsp;</td></tr>
            <tr>
                <td>Add associated documents/pdfs:</td>
                <td>
                    <input type="file" id="File1" name="document_upload"> 
                </td>
            </tr>

            <tr><td>&nbsp;</td></tr>    
            <tr>
				<td></td>
				<td> <input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn btn-primary" />
				</td>
                <input id="ArticleContent" name="ArticleContent" type="hidden" />
                  <input id="Submitted" name="Submitted" type="hidden" value="true"/>
			 </tr> 
          </table>
      </div>
      </div>
    </form>
  </div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>