<?php
require_once('../includes/class-lib.php');
$article_list = get_article_list();
?>
<p><a href="article-create.php" class="btn btn-primary">Add new article</a></p>

<table class="table table-striped">
    <tr>
      <th>id</th><th>Title</th><th>Published</th><th>Edit</th><th>Delete</th>
    </tr>
  <?php foreach ($article_list as $Article) { ?>
  <tr>
    <td><?= $Article->id;?></td>
    <td><?= $Article->title;?></td>
    <td><?= format_date($Article->published);?></td>
    <td><a href="article-update.php?id=<?= $Article->id;?>" class="btn btn-primary">edit</a></td>
    <td><a href="article-delete.php?id=<?= $Article->id;?>" class="btn btn-danger">delete</a></td>
  </tr>
    <?php } ?>
  </tbody>
</table>

<p><a href="article-create.php" class="btn btn-primary">Add new article</a></p>
