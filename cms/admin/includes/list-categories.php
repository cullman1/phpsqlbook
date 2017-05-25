<?php
$category_list = get_category_list();
?>

<p><a href="category-create.php" class="btn btn-primary">Add new category</a></p>

<table class="table table-striped">
  <tr>
    <th>id</th><th>Name</th><th>Description</th><th>Edit</th><th>Delete</th>
  </tr>

  <?php foreach ($category_list as $category) { ?>
  <tr>
    <td><?=$category->id;?></td>
    <td><?=$category->name;?></td>
    <td><?=$category->description;?></td>
    <td><a href="category-update.php?id=<?=$category->id;?>" class="btn btn-primary">edit</a></td>
    <td><a href="category-delete.php?id=<?=$category->id;?>" class="btn btn-danger">delete</a></td>
  </tr>
    <?php } ?>
</table>

<p><a href="category-create.php" class="btn btn-primary">Add new category</a></p>
