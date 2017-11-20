<?php
  require_once '../config.php';
//  $userManager->redirectNonAdmin();
  $category_list   = $categoryManager->getAllCategories();
  include 'includes/header.php';
?>
<section>
  <a class="btn btn-primary" href="category.php?action=create">create category</a>
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
        <td><?= htmlentities($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlentities($category->description, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= ($category->navigation ? 'Yes' : 'No') ?></td>
        <td><a class="btn btn-primary" href="category.php?id=<?= $category->id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger" href="category-delete.php?id=<?= $category->id?>">delete</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>