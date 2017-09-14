<?php
  require_once '../config.php';

  $userManager->redirectNonAdmin();
  $category_list   = $categoryManager->getAllCategories();

  include 'includes/header.php';
?>

<a class="btn btn-primary" href="category.php?action=create">create</a>

<table class="table">
  <thead>
  <tr>
    <th>Name</th>
    <th>Description</th>
    <th>In navigation</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
    <?php foreach ($category_list as $category) { ?>
    <tr>
      <td><?= $category->name ?></td>
      <td><?= $category->description ?></td>
      <td><?= ($category->navigation ? 'Yes' : 'No') ?></td>
      <td><a class="btn btn-primary" href="category.php?id=<?= $category->id?>&action=update">edit</a></td>
      <td><a class="btn btn-danger" href="category-delete.php?id=<?= $category->id?>">delete</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php
  include 'includes/footer.php';
?>