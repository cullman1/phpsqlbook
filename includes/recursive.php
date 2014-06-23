<?php
//Add Nested comments
  mysql_data_seek($stmt4,0);
  while($row4 = mysql_fetch_array($stmt4)) 
  { 
    if ($_SESSION["previous_comment_id"] == $row4["comment_repliedto_id"])
    {  ?>
      <div id="indentbox" style="padding-left:50px;">
        <?php include("../includes/replybox2.php"); ?>
      </div>
<?  }
  }
 ?>