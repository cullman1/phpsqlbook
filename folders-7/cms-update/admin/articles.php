<?php
  require_once '../config.php';

  $cms->userManager->redirectNonAdmin();

  $article_list  = $cms->articleManager->getAllArticleSummaries(0,1);
  
  include 'includes/header.php';
?>
<section>

  <a class="btn btn-primary" href="article.php?include=croppie&action=create">create article</a>


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
        <td><img src="../uploads/thumb/<?= CMS::cleanLink($article->image_file);  ?>" alt="<?= CMS::cleanLink($article->image_alt); ?>"></td>
        <td><?= CMS::clean($article->title); ?></td>
        <td><?= CMS::clean($article->category); ?></td>
        <td><?= ($article->published ? 'Yes' : 'No') ?></td>
        <td><?= CMS::clean($article->author); ?></td>
        <td><a class="btn btn-primary" href="article.php?include=croppie&id=<?= $article->article_id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger delete" href="article-delete.php?id=<?= $article->article_id?>">delete</a></td>
      </tr>
      <?php  } ?>
    </tbody>
  </table>

</section>

<?php include 'includes/footer.php'; ?>

