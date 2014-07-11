<?php 

//Show comments
$select_comments_row = array();
unset($new);
while( $select_nestedcomments_row = mysql_fetch_array($select_nestedcomments_result))
{
    $select_comments_row[] = $select_nestedcomments_row;
}
  
foreach ($select_comments_row as $a)
{
    $new[$a['comment_repliedto_id']][] = $a;
}
 $tree = createTree($new, $new[0]); // changed
 
 include("../includes/reply-box-parent.php");

?>