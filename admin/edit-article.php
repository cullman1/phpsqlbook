<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting article and associated media. */
$select_article_sql = "SELECT title, content, article.article_id,  category_id, parent_id FROM article where article.article_id=".$_REQUEST['article_id'];
$select_article_result = mysql_query($select_article_sql);
if(!$select_article_result) {   die("Select article failed: ". mysql_error()); }

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM category";
$select_category_result = mysql_query($select_category_sql);
if(!$select_category_result) { die("Select category failed: ". mysql_error()); }

/* Query SQL Server for selecting parent. */
$select_parent_sql = "select parent_id, parent_name FROM parent";
$select_parent_statement = mysql_query($select_parent_sql);
if(!$select_parent_statement) {  die("Select parent failed: ". mysql_error()); }

/* Query SQL Server linking media to article via media link table. */
$select_medialink_sql = "select * FROM media_link JOIN 387732_phpbook1.media ON media.media_id = media_link.media_id where media.article_id=".$_REQUEST['article_id'];
$select_medialink_statement = mysql_query($select_medialink_sql);
if(!$select_medialink_statement) {  die("Select media Query failed: ". mysql_error()); }

/* Postback */
if (isset($_REQUEST['Submitted']))
{
    /* Update contents of article table */
    $update_article_sql = "UPDATE 387732_phpbook1.article SET title= '" .$_REQUEST["ArticleTitle"]."', content='" .$_REQUEST["ArticleContent"]. "', category_id=" .$_REQUEST["CategoryId"]. ", parent_id=" .$_REQUEST["PageId"]. " where article_id=".$_REQUEST["article_id"];
    $update_article_result = mysql_query($update_article_sql);
    if(!$update_article_result)
    {  
        /* Error Message */
        die("Query failed: ". mysql_error());
    }
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
                $insert_media_result = mysql_query($insert_media_sql);
                if(!$insert_media_result)
                {  
                    /* Error Message */
                    die("Insert Media Query failed: ". mysql_error());
                }

                /* Query SQL Server for inserting media link into link table. */
                $insert_medialink_sql = "INSERT media_link (article_id, media_id) VALUES  (".$_REQUEST["article_id"].",".mysql_insert_id().")";
                $insert_medialink_result = mysql_query($insert_medialink_sql);
                if(!$insert_medialink_result)
                { 
                    /* Error Message */
                    die("Insert Media Link Query failed: ". mysql_error());
                }
            }
        }

        if($_REQUEST['fimagehidden']!="")
        {
            $update_media_sql = "UPDATE 387732_phpbook1.media SET article_id =".$_REQUEST["article_id"]." where media_id=".$_REQUEST['fimagehidden'];
            $update_media_statement = mysql_query($update_media_sql);
            if(!$update_media_statement)
            { 
                /* Error Message */
                die("Update media Query failed ". mysql_error());
            }
        }
    }  
}

include '../includes/header-editor.php' ?>

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
  <form id="form1" method="post" action="edit-article.php" onsubmit="assigncontent()" enctype="multipart/form-data">
    <?php while($select_article_row = mysql_fetch_array($select_article_result)) { ?>
      <div id="middlewide">
        <div id="leftcol">
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
            <table>
              <tr>
                <td><span class="fieldheading">Title:</span></td>
                <td><input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php echo $select_article_row['title']; ?>"/></td> 
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="fieldheading">Content:</span></td>
                <td>
               
                <?php include '../includes/richtextcontrol.php' ?>

                </td> 
              </tr>
              <tr><td id='placehere'>&nbsp;</td></tr>
              <tr>
                <td>Featured Image:</td>
                <td>
                  <?php include '../includes/gallery-modal.php' ?> 
                  <?php if (isset($_REQUEST["imgname"]))
                        { 
                          echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; 
                        } 
                        else if (isset($select_article_row['name']))
                        { 
                            echo "<input type='text' id='fimage' name='fimage' value='".$select_article_row['name']."' readonly/>"; 
                        } 
                        echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='"; 
                        if (isset($_REQUEST["pressed"]))
                        { 
                            echo $_REQUEST["pressed"];
                        } 
                        else if(isset($select_article_row['media_id']))
                        { 
                            echo $select_article_row['media_id'];
                        } 
                        echo "' />"; 
                  ?>
                </td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td>Associated Docs:</td>
                <td>
                <?php while($select_medialink_row = mysql_fetch_array($select_medialink_statement)) 
                  {
                      if (isset($select_medialink_row['name']) && ($select_medialink_row['file_type']!="image/jpeg" && $select_medialink_row['file_type']!="image/png"))
                    { 
                        echo $select_medialink_row['name'] ." - " . "<span name='deletebutton".$select_medialink_row['media_id']."' class='glyphicon glyphicon-remove red deleter'></span></div><br/>"; 
                          echo "<input type='hidden' id='fdochidden". $select_medialink_row['media_id']."' name='fdochidden". $select_medialink_row['media_id']."' value='' />"; 
                    } 
                  }
                  ?> 
                <input type="file" id="document_upload" name="document_upload"> 
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>   
                  <select id="CategoryId" name="CategoryId">     
                    <?php while($select_category_row = mysql_fetch_array($select_category_result)) { ?>
                    <option value="<?php  echo $select_category_row['category_id']; ?>"<?php if( $select_category_row['category_id'] == $select_article_row['category_id']) { echo "selected";} ?> ><?php  echo $select_category_row['category_name']; ?></option>
                    <?php } ?> 
                  </select>
              </td>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Parent Page:&nbsp;</span></td>
              <td>   
                  <select id="PageId" name="PageId">
                    <?php while($select_parent_row = mysql_fetch_array($select_parent_statement)) { ?>
                    <option value="<?php  echo $select_parent_row['parent_id']; ?>"  <?php if( $select_parent_row['parent_id'] == $select_article_row['parent_id']) { echo "selected";} ?>><?php  echo $select_parent_row['parent_name']; ?></option>
                    <?php } ?> 
                  </select>
             </td>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td></td>
                <td> <input id="SaveButton" type="submit" name="submit" Value="Submit"  /><input id="ArticleContent" name="ArticleContent" type="hidden" value=""/></td>  
            </tr> 
            </table>
          </div>
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