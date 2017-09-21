<?php
  require_once '../config.php';

  $userManager->redirectNonAdmin();

  $article_list  = $articleManager->getAllArticleSummaries();

  include 'includes/header.php';
?>
<section>

  <a class="btn btn-primary" href="article.php?action=create">create article</a>


  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>Title</th>
        <th>Category</th>
        <th>Published</th>
        <th>Author</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($article_list as $article) { ?>
      <tr>
        <td><img src="<?= $article->thumb ?>" alt="<?= $article->thumb_alt ?>"></td>
        <td><?= $article->title?></td>
        <td><?= $article->category?></td>
        <td><?= ($article->published ? 'Yes' : 'No') ?></td>
        <td><?= $article->author?></td>
        <td><a class="btn btn-primary" href="article.php?id=<?= $article->id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger delete" href="article-delete.php?id=<?= $article->id?>">delete</a></td>
      </tr>
      <?php  } ?>
    </tbody>
  </table>

</section>

<?php include 'includes/footer.php'; ?>

