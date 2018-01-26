<?php
  require_once '../config.php';
  $userManager->redirectNonAdmin();
  $categories   = $categoryManager->getAllCategories();
  include 'includes/header.php';
?>
<section>
  <a class="btn btn-primary" href="category.php?action=create">create category</a>
  <table class="table">
    <thead>
      <tr><th>Name</th>
          <th>Description</th>
          <th>In navigation</th>
          <th></th>
          <th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $category) { ?>
        <tr><td><?= htmlentities($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlentities($category->description, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= ($category->navigation ? 'Yes' : 'No') ?></td>
            <td><a href="category.php?category_id=<?= $category->category_id?> 
                 &action=update" class="btn btn-primary">edit</a></td>
            <td><a href="category-delete.php?category_id=<?= $category->category_id?>"
                 class="btn btn-danger delete">delete</a></td></tr>
      <?php } ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>