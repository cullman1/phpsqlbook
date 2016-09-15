<?php  require_once('authenticate.php'); 
require_once('../includes/db_config.php');

function unpublish_article($dbHost, $id) {
    $query = "update article set date_published = null WHERE article_id= :id";
    $statement->bindParam(":id", $id);
    $statement = $dbHost->prepare($query);
    $statement->execute();
    header('Location:../admin/index.php');
}

function publish_article($dbHost, $date, $id) {
        $query = "update article set date_published = :date WHERE article_id= :id";
        $statement = $dbHost->prepare($query);
        $statement->bindParam(":id",  $id);
        $statement->execute();
         header('Location:../admin/index.php');
}

if (isset($_GET["publish"])) {
   unpublish_article($dbHost, $GET["articleid"]);
} else {
    if (isset($_POST["Submitted"])) {
        $date =  date("Y/m/d, h:i:s");
        if($_POST["articlecontent"]!="") {
            $date= date("Y/m/d, h:i:s", strtotime($_POST["articlecontent"]));	
        }
        publish_article($dbHost, $date, $GET["articleid"]);
    } 
    
    include ('../includes/header.php');  ?>
    <script type="text/Javascript">
        function assigncontent() {
            var sHTML = $('#datetimepick').val();  
            $('#articlecontent').val(sHTML);
        }
        </script>
        <h2>Publish article</h2>
        <form method="post" action="publish-data.php" onsubmit="assigncontent()">
            <label for="today">Immediately</label>
            <input type="checkbox" id="immediatepublish" name="immediatepublish" onchange="if ( $('#dtb').css('visibility') == 'hidden' ) $('#dtb').css('visibility','visible'); else $('#dtb').css('visibility','hidden');"/>
            
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
            <input id="articleid" name="articleid" type="hidden" value="<?php echo $_POST["articleid"]?>"/>
            <input id="articlecontent" name="articlecontent" type="hidden" value=""/>
            <input id="Submitted" name="Submitted" type="hidden" value="true"/>
    </form>
<?php }   
include '../includes/footer.php' ?>