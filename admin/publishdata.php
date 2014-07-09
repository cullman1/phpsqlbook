<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

if (isset($_REQUEST["publish"]))
{
    /* Query to update article publish date*/
    $update_article_sql = "update article set date_published = null WHERE article_id=".$_REQUEST["articleid"];
    $update_article_result = mysql_query($update_article_sql);
    if(!$update_article_result) { die("Update Article Publish Date Query failed: ". mysql_error()); }
    else
    {
        /* Redirect to original page */
        header('Location:../admin/pages.php');
    }
} 
else 
{
    if (isset($_REQUEST["Submitted"]))
    {
        /* Query to update article publish date*/
        
        $date =  date("Y/m/d, h:i:s");
        if($_REQUEST["articlecontent"]!="")
        {
            $date= date("Y/m/d, h:i:s", strtotime($_REQUEST["articlecontent"]));	
        }

        /* Query to update publish date*/
        $update_publishdate_sql = "update article set date_published = '".$date."' WHERE article_id=".$_REQUEST["articleid"];
        $update_publishdate_result = mysql_query($update_publishdate_sql);
        if(!$update_publishdate_result) {  die("Query failed: ". mysql_error()); } else 
        {
            /* Redirect to original page */
            header('Location:../admin/pages.php');
        }
    } 
    
    include ('../includes/header.php');  ?>
    <div id="publishcontainer">
        <script type="text/Javascript">
        function assigncontent()
        {
            var sHTML = $('#datetimepick').val();  
            $('#articlecontent').val(sHTML);
        }
        </script>
        <h2>Publish article</h2>
        <form method="post" action="publishdata.php" onsubmit="assigncontent()">
            <label for="today">Immediately</label>
            <input type="checkbox" id="immediatepublish" name="immediatepublish" onchange="if ( $('#dtb').css('visibility') == 'hidden' ) $('#dtb').css('visibility','visible'); else $('#dtb').css('visibility','hidden');"/>
            <div id="dtb">
                <div>or</div>
                <div>Future Date</div>
                <div id="datetimepicker" class="input-append date">
                    <input id="datetimepick" name="datetimepick" type="text" />
                    <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                </div>
                <script type="text/javascript">
                    $('#datetimepicker').datetimepicker({
                    format: 'yyyy/MM/dd hh:mm:ss',
                    language: 'en-US'
                    });
                </script>
            </div>
            <br/>
            <input id="SaveButton" type="submit" name="submit" Value="Publish Article"  />
            <input id="articleid" name="articleid" type="hidden" value="<?php echo $_REQUEST["articleid"]?>"/>
            <input id="articlecontent" name="articlecontent" type="hidden" value=""/>
            <input id="Submitted" name="Submitted" type="hidden" value="true"/>
        </div> <!-- /container -->
    </form>
</div>
<?php 
}   
include '../includes/footer.php' ?>