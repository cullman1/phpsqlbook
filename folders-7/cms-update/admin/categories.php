<?php
  require_once '../config.php';
  $cms->userManager->redirectNonAdmin();
  $category_list   = $cms->categoryManager->getAllCategories();
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
        <td><?= CMS::clean($category->name); ?></td>
        <td><?= CMS::clean($category->description); ?></td>
        <td><?= ($category->navigation ? 'Yes' : 'No') ?></td>
        <td><a class="btn btn-primary" href="category.php?id=<?= $category->category_id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger delete" href="category-delete.php?id=<?= $category->category_id?>">delete</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>