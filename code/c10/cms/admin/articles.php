<?php
  require_once '../config.php';
  $cms->userManager->redirectNonAdmin();
  $article_list  = $cms->articleManager->getArticleSummaries(0,1);
  include 'includes/header.php';
?>
<section>
  <a class="btn btn-primary" href="article.php?action=create">create article</a>
  <table class="table">
    <thead>
      <tr>
        <th>Image</th><th>Title</th><th>Category</th><th>Published</th>
        <th>Author</th><th>Edit Article</th><th>Delete Article</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($article_list as $article) { ?>
      <tr>
        <td><img src="../uploads/thumb/<?= CMS::clean($article->image_file);  ?>"
       alt="<?= CMS::clean($article->image_alt); ?>"></td>
        <td><?= CMS::clean($article->title); ?></td>
        <td><?= CMS::clean($article->category); ?></td>
        <td><?= ($article->published ? 'Yes' : 'No') ?></td>
        <td><?= CMS::clean($article->author); ?></td>
        <td><a class="btn btn-primary" href="article.php?article_id=<?= $article->article_id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger delete" href="article-delete.php?article_id=<?= $article->article_id?>">delete</a></td>
      </tr>
      <?php  } ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>