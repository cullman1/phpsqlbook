  <div class="card" style="width:20rem; margin: 0.4rem;">
    <a href="view-article.php?id=<?= $article->id?>"><img class="card-img-top" src="uploads/<?= $article->thumb ?>" alt="<?= $article->thumb_alt ?>"></a>
    <div class="card-body text-center">
      <h5 class="card-title"><?= $article->title?></h5>
      <p><?= $article->category ?> by <?= $article->author?></p>
      <p><?= $article->summary ?></p>
    </div>
  </div>