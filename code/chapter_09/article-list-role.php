<?php
  require_once('../includes/database_connection.php'); 
  require_once('../includes/functions.php');
  session_start();
  $article_list  = get_article_list();

function has_permission($task) {
  $permission = false;
  foreach($_SESSION['tasks'] as $key=>$value) {  // for each task
    if ($value['name'] == $task) {               // if task name matches $task
      $permission = true;                        // permission is granted
    }
  }  
  return $permission;
}

include '../chapter_09_old/includes/header.php';
?>

<div class="panel">
<div class="new">

<?php 
if (!isset($_SESSION['tasks']))  {
  header('Location:login-role.php');
} 
if (has_permission('article_add')) { // delete article  ?>  
  <a href="article-edit.php?action=add">add article</a>
<?php } ?>


</div><table>
  <tr>
    <th>Thumb</th><th>Title</th><th>Published</th><th>Category</th><th></th><th></th>
  </tr>
  <?php foreach ($article_list as $article) { ?>
  <tr>
    <td><img src="../<?= $article->filepath ? $article->filepath : '../uploads/blank.png'; ?>" alt="<?= $article->alt; ?>" width="40" /></td>
    <td><?=$article->title;?></td>
    <td><?= !is_null($article->published) ? $article->published  : "not published"; ?></td>
    <td><?=$article->name;?></td>
    <td>
        <?php if (has_permission('article_edit')) { // delete article  ?>  
          <a href="article-edit.php?action=edit&amp;article_id=<?=$article->id;?>">
            edit</a>
        <?php } ?>
      </td>
      <td>
        <?php if (has_permission('article_delete')) { // delete article  ?>  
          <a href="article-edit.php?action=delete&amp; article_id=<?=$article->id;?>">  
           delete</a>
        <?php } ?>
        </td>

  </tr>
  <?php } ?>
</table>
</div>
<?php include 'includes/footer.php'; ?>