<?php
  require_once '../classes/config.php';

  $cms                = new CMS($database_config);
  $articleManager = $cms->getArticleManager();
  $article_list       = $articleManager->getAllArticles();

  include 'includes/header.php';
?>

<a class="btn btn-primary" href="article-create.php">create</a>


<table class="table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Published</th>
      <th>Author</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($article_list as $article) { ?>
  <tr>
    <td><img src="<?= $article->filepath ?>" alt="<?= $article->alt ?>" type="<?= $article->type ?>"></td>
    <td><?= $article->title?></td>
    <td><?= $article->published?></td>
    <td><?= $article->author?></td>
    <td><a class="btn btn-primary" href="article-edit.php?id=<?= $article->id?>">edit</a></td>
    <td><a class="btn btn-danger" href="article-delete.php?id=<?= $article->id?>">delete</a></td>
  </tr>
  <?php  } ?>
  </tbody>
</table>

<?php include 'includes/footer.php'; ?>

