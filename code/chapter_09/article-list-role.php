<?php

require_once('includes/database_connection.php'); 
require_once('includes/functions.php'); 
session_start();
$message = '';
$publish = '';
$article_list  = get_article_list();

function find_task($task) {
  $permission = false;
  foreach($_SESSION["tasks"] as $key=>$value) {           // loop through items and remove it if current one remove it 
    if ($value["name"] == $task) {
      $permission = true;
    }
  }  
	return $permission;
}

include 'includes/header.php';
?>

<div class="panel">
<div class="new"><a href="article-edit.php?action=add" class="button">Add article</a></div>
<table>
  <tr>
    <th>Thumb</th><th>Title</th><th>Published</th><th>Category</th><th></th><th></th>
  </tr>
  <?php foreach ($article_list as $article) { ?>
  <tr>
    <td><img src="../<?= $article->filepath ? $article->filepath : '../uploads/blank.png'; ?>" alt="<?= $article->alt; ?>" width="40" /></td>
    <td><?=$article->title;?></td>
    <td><?= !is_null($article->published) ? $article->published  : "not published"; ?></td>
    <td><?=$article->name;?></td>
    <td><a href="article-edit.php?action=edit&amp;article_id=<?=$article->id;?>" class="button confirmation">edit</a></td>
    <?php if (find_task("delete article")) { ?>  <td><a href="article-edit.php?action=delete&amp;article_id=<?=$article->id;?>" class="button confirmation">delete</a></td><?php } ?>
  </tr>
  <?php } ?>
</table>
</div>
<?php include 'includes/footer.php'; ?>