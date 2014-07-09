<?php 

//Show comments
$row3 = array();
unset($new);
while( $result = mysql_fetch_array($stmt4))
{
    $row3[] = $result;
}
  
foreach ($row3 as $a)
{
    $new[$a['comment_repliedto_id']][] = $a;
}
 $row4 = createTree($new, $new[0]); // changed
 
 include("../includes/replybox2.php");

?>