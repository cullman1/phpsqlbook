<?php 
/* Login check */
require_once('authenticate.php'); 

/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM 387732_phpbook1.category";
$select_category_result = mysql_query($select_category_sql);
if(!$select_category_result){  die("Select Category failed: ". mysql_error()); }

/* Query SQL Server for selecting parent page. */
$select_parent_sql = "select parent_id, parent_name FROM 387732_phpbook1.parent";
$select_parent_result = mysql_query($select_parent_sql);
if(!$select_parent_result) {   die("Select Parent failed: ". mysql_error()); }

/* Postback */
if (isset($_REQUEST['ArticleTitle']))
{
    /* Query SQL Server for inserting article. */
    $insert_article_sql = "INSERT INTO article (title, content, date_posted, category_id, parent_id, user_id) VALUES ('".$_REQUEST['ArticleTitle']."', '".$_REQUEST['ArticleContent']."',  '". date("Y-m-d H:i:s") ."', '".$_REQUEST['CategoryId']."', '".$_REQUEST['PageId']."', '".$_SESSION['authenticated']."')";
    $insert_article_result = mysql_query($insert_article_sql);
    $newarticleid = mysql_insert_id();
    if(!$insert_article_result)
    {  
        /* Error Message */
        die("Insert article Query failed: ". mysql_error());
    }
    else
    {
        $articleid = "0";
        if(isset($_REQUEST['article_id']))
        {
            $articleid = $_REQUEST['article_id'];
        }
        else
        {
            $articleid = mysql_insert_id($conn);
        }

        
        if(isset($_FILES['document_upload']))
        {
            if($_FILES["document_upload"]["name"]!="")
            {
                $folder = "../uploads/".$_FILES["document_upload"]["name"];
                move_uploaded_file($_FILES['document_upload']['tmp_name'], $folder);
                
                /* Query SQL Server for inserting media. */
                $insert_media_sql = "INSERT INTO media (media_title, name, file_type, url, size, date_uploaded) VALUES ('".$_FILES["document_upload"]["name"]."','".$_FILES['document_upload']['name']."', '".$_FILES['document_upload']['type']."', '".$folder."', '".$_FILES['document_upload']['size']."', '". date("Y-m-d H:i:s") ."')";
                $insert_media_result = mysql_query($insert_media_sql);
                if(!$insert_media_result)
                {  
                    /* Error Message */
                    die("Insert Media Query failed: ". mysql_error());
                }
                $newmediaid = mysql_insert_id();

                /* Query SQL Server for inserting media link. */
                $insert_medialink_sql = "INSERT INTO media_link (article_id, media_id) VALUES (".$newarticleid.", '".$newmediaid."')";
                $insert_medialink_result = mysql_query($insert_medialink_sql);
                if(!$insert_medialink_result)
                {  
                    /* Error Message */
                    die("Insert Media Link Query failed: ". mysql_error());
                }
            }
        }

        if(isset($_REQUEST['fimagehidden']))
        {
            /* Query SQL Server for updaing media. */
            $update_media_sql = "UPDATE media set article_id =".$articleid." where media_id=".$_REQUEST['fimagehidden'];
            $update_media_result = mysql_query($update_media_sql);
            if(!$update_media_result)
            { 
                /* Error Message */
                die("Update Media Query failed: ". mysql_error());
            }
            else
            {
                /* Redirect to original page */
                header('Location:../admin/AddArticle2.php?submitted=true');
            }
        }
        else
        {
            /* Redirect to original page */
            header('Location:../admin/AddArticle2.php?submitted=true');
        }
    }
}

/* Add header */
include '../includes/headereditor2.php' ?>

<script type="text/Javascript">
function assigncontent()
{
  var textControl = document.getElementById("some-textarea");
  var sHTML = textControl.innerHTML;
  var sHTML2 = $('#ArticleTitle').val();
  $('#ArticleContent').val(sHTML);
  $('#ArticleTitle').val(sHTML2);
}
</script>

<div id="body">
    <form id="galleryform" method="post" action="addarticle2.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add an Article</h2><br />
             <div id="Status_Post">
            <?php 
             if(isset($_GET['submitted']))
             {
              echo "<span class='red' style='color:red;'>Article successfully created!</span>";
             }  
           ?>
         </div>
          <table>
            <tr>
		        <td><span class="fieldheading">Title:</span></td>
				<td><input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php if (isset($_REQUEST["title"])){ echo $_REQUEST["title"]; }?>" /></td> 
			</tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
		        <td style="vertical-align:top;"><span class="fieldheading">Content:&nbsp;</span></td>
				<td>     
                    <?php include '../includes/richtextcontrol.php' ?>
                </td> 
			</tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>
                  <select id="CategoryId" name="CategoryId">
                     <?php while($select_category_row = mysql_fetch_array($select_category_result)) { ?>
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
                        <?php while($select_parent_row = mysql_fetch_array($select_parent_result)) { ?>
                        <option value="<?php  echo $select_parent_row['parent_id']; ?>"><?php  echo $select_parent_row['parent_name']; ?></option>
                        <?php } ?> 
                    </select>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Featured Image:</td>
              <td>
                <?php include '../includes/gallerymodaloriginal.php' ?> <?php if (isset($_REQUEST["imgname"])){ echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; } if(isset($_REQUEST["pressed"])){ echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='".$_REQUEST["pressed"]."' />"; }?>
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
                    <input id="SaveButton" type="submit" name="submit" Value="Submit"  />
				</td>
                <input id="ArticleContent" name="ArticleContent" type="hidden" />
			 </tr> 
          </table>
          <br />
          <br />
       
      </div>
      <br />
      <a id="Return2" href="../index.html">Return to Main Page</a>
      </div>
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footereditor2.php' ?>
