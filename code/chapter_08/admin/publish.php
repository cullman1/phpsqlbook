<?php  require_once('authenticate.php'); 
require_once('../includes/db_config.php');

function unpublish_article($dbHost,$id) {
  $query = "update article set date_published = null WHERE article_id= :id";
  $statement = $dbHost->prepare($query);
    $statement->bindParam(":id", $id);
  $statement->execute();
  header('Location:../admin/index.php');
}

function publish_article($dbHost,$date,$id) {
  $query = "update article set date_published = :date WHERE article_id= :id";
  $statement = $dbHost->prepare($query);
  $statement->bindParam(":id", $id);
    $statement->bindParam(":date", $date);
  $statement->execute();
  header('Location:../admin/index.php');
}

if (isset($_GET["publish"])) {
 unpublish_article($dbHost, $_GET["id"]);
} else {
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $date =  date("Y/m/d h:i:s");
  if($_POST["content"]!="") {
   $date= date("Y/m/d h:i:s", strtotime($_POST["content"]));
  }
  publish_article($dbHost, $date, $_POST["id"]);
 }
    include ('../includes/header.php');  ?>
    <script type="text/Javascript">
  function assigncontent() {
   var sHTML = $('#datetimepick').val();  
   $('#content').val(sHTML); }
  </script>
  <h2>Publish article</h2>
  <form method="post" action="publish.php" onsubmit="assigncontent()">
  <label for="today">Immediately</label>
  <input type="checkbox" name="pub_now" onchange="if ($('#dtb').css('visibility')== 'hidden') $('#dtb').css('visibility','visible'); else $('#dtb').css('visibility','hidden');"/>
  <div>or</div>
  <div>Future Date</div>
  <div id="datetimepicker" class="input-append date">
   <input id="datetimepick" name="datetimepick" type="text" />
 <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
  </div>
  <script type="text/javascript">
    $('#datetimepicker').datetimepicker({
    format: 'yyyy/MM/dd hh:mm:ss',
    language: 'en-US' });
  </script>
 <br/><input type="submit" name="submit" Value="Publish Article" />
 <input name="id" type="hidden" value="<?php echo $_GET["id"]?>"/>
 <input id="content" name="content" type="hidden" value=""/>
</form>

<?php }   
include '../includes/footer.php' ?>