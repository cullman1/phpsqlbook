<?php 

//Show comments
$row3 = array();
unset($new);
while( $select_nestedcomments_row = mysql_fetch_array($select_nestedcomments_result))
{
    $row3[] = $select_nestedcomments_row;
}
  
foreach ($row3 as $a)
{
    $new[$a['comment_repliedto_id']][] = $a;
}
 $row4 = createTree($new, $new[0]); // changed
 
 include("../includes/replybox2.php");

?>