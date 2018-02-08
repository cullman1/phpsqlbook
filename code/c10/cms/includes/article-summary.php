<div class="card article-summary">
  <a href="<?= ROOT ?>view-article.php?article_id=<?= $article->article_id ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= $article->image_file ?>"
     alt="<?= CMS::clean($article->image_alt) ?>"></a>
  <div class="card-body text-center">
    <a href="<?= ROOT ?>view-article.php?article_id=<?= $article->article_id ?>">
      <h5 class="card-title" ><?= CMS::clean($article->title) ?>
      </h5></a>
    <p><?= CMS::clean($article->summary) ?></p>
    <p>Posted in <a href="<?= ROOT ?>view-category.php?category_id=<?= $article->category_id ?>">
      <?= CMS::clean($article->category) ?></a> by
      <a href="<?= ROOT ?>view-user.php?user_id=<?= $article->user_id ?>">
      <?= CMS::clean($article->author) ?></a>
    </p>
  </div>
</div>