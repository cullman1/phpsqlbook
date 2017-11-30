<div class="card article-summary">
  <a href="<?= ROOT ?>view-article.php?id=<?= $article->id ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= $article->media_file ?>"
     alt="<?= $article->media_alt ?>"></a>
  <div class="card-body text-center">
    <a href="<?= ROOT ?>view-article.php?id=<?= $article->id ?>">
      <h5 class="card-title" ><?= $article->title ?></h5></a>
    <p><?= $article->summary ?></p>
    <p>Posted in <a href="<?= ROOT ?>view-category.php?id=<?= $article->category_id ?>">
      <?= $article->category ?></a> by       
      <a href="<?= ROOT ?>view-user.php?id=<?= $article->user_id ?>">
      <?= $article->author ?></a>
    </p>
  </div>
</div>