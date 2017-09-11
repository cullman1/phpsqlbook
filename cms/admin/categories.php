<?php
  require_once '../classes/config.php';

  $cms             = new CMS($database_config);
  $categoryManager = $cms->getCategoryManager();
  $category_list   = $categoryManager->getAllCategories();

  include 'includes/header.php';
?>

<a class="btn btn-primary" href="category-create.php">create</a>

<table class="table">
  <thead>
  <tr>
    <th>Name</th>
    <th>Description</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
    <?php foreach ($category_list as $category) { ?>
    <tr>
      <td><?= $category->name ?></td>
      <td><?= $category->description ?></td>
      <td><a class="btn btn-primary" href="category-update.php?id=<?= $category->id?>">edit</a></td>
      <td><a class="btn btn-danger" href="category-delete.php?id=<?= $category->id?>">delete</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php

include 'includes/footer.php';
?>

