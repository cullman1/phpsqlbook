<?php
  require_once '../config.php';

  $userManager->redirectNonAdmin();

  $article_list  = $articleManager->getAllArticleSummaries(0,1);
  
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
        <td><img src="../uploads/thumb/<?= htmlentities($article->media_file, ENT_NOQUOTES, 'UTF-8');  ?>" alt="<?= htmlentities($article->media_alt, ENT_NOQUOTES, 'UTF-8'); ?>"></td>
        <td><?= htmlentities($article->title, ENT_NOQUOTES, 'UTF-8'); ?></td>
        <td><?= htmlentities( $article->category, ENT_NOQUOTES, 'UTF-8'); ?></td>
        <td><?= ($article->published ? 'Yes' : 'No') ?></td>
        <td><?= htmlentities($article->author, ENT_NOQUOTES, 'UTF-8'); ?></td>
        <td><a class="btn btn-primary" href="article.php?id=<?= $article->id?>&action=update">edit</a></td>
        <td><a class="btn btn-danger delete" href="article-delete.php?id=<?= $article->id?>">delete</a></td>
      </tr>
      <?php  } ?>
    </tbody>
  </table>

</section>

<?php include 'includes/footer.php'; ?>

