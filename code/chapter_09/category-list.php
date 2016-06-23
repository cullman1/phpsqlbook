<?php
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';
$category_list = get_category_list();

include 'includes/header.php';
?>


<div class="panel">

<div class="new"><a href="category-edit.php?action=add" class="button">Add category</a></div>

<table>
  <tr>
    <th>Category name</th><th>Template</th><th></th><th></th>
  </tr>

  <?php foreach ($category_list as $category) { ?>
  <tr>
    <td><?=$category->name;?></td>
    <td><?=$category->template;?></td>
    <td><a href="category-edit.php?action=edit&category_id=<?=$category->id;?>" class="button">edit</a></td>
    <td><a href="category-edit.php?action=delete&category_id=<?=$category->id;?>" class="button confirmation">delete</a></td>
  </tr>
    <?php } ?>
</table>
</div>
<?php include 'includes/footer.php'; ?>