<div class="card article-summary">
  <a href="<?= ROOT ?>view-article.php?id=<?= $article->id ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= $article->media_file ?>"
     alt="<?= htmlentities($article->media_alt , ENT_QUOTES, 'UTF-8') ?>"></a>
  <div class="card-body text-center">
    <a href="<?= ROOT ?>view-article.php?id=<?= $article->id ?>">
      <h5 class="card-title" ><?= htmlentities($article->title, ENT_QUOTES, 'UTF-8') ?>  
      </h5></a>
    <p><?= htmlentities($article->summary, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Posted in <a href="<?= ROOT ?>view-category.php?id=<?= $article->category_id ?>">
      <?= htmlentities($article->category, ENT_QUOTES, 'UTF-8') ?></a> by       
      <a href="<?= ROOT ?>view-user.php?id=<?= $article->user_id ?>">
      <?= htmlentities($article->author, ENT_QUOTES, 'UTF-8') ?></a>
    </p>
  </div>
</div>