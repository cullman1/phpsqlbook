<?php
  require_once('/includes/database-connection.php'); 
  require_once('/includes/functions.php');
  session_start();
  $article_list  = get_article_list();
?>

<?php 
print_r ($_SESSION['tasks']);
if (!isset($_SESSION['tasks']))  {
  header('Location:login.php');
} 
if (has_permission('article_add')) { // delete article  ?>  
  <a href="article-edit.php?action=add">add article</a>
<?php } ?>

<table>
  <tr>  					      
    <th>Thumb</th><th>Title</th><th>Published</th><th>Category</th><th></th><th></th>
  </tr>
  <?php foreach ($article_list as $article) { ?>
    <tr>
      <td>
         <img src="../<?= $article->filepath ? $article->filepath : 'blank.png'; ?>"  
              alt="<?= $article->alt; ?>" width="20" />
      </td>
      <td><?=$article->title;?></td>			      
      <td><?= !is_null($article->published) ? $article->published  : 'X'; ?></td>
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