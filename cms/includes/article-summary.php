  <div class="card" style="width:20rem; margin: 0.4rem;">
    <a href="<?= $category->seo_name ?>/<?= $article->seo_title ?>"><img class="card-img-top" src="uploads/<?= $article->thumb ?>" alt="<?= $article->thumb_alt ?>"></a>
    <div class="card-body text-center">
      <h5 class="card-title"><?= $article->title?></h5>
         <?php
        
         if ($userManager->isLoggedIn() && $article->liked) {
        echo '<i class="fa fa-heart"></i> ';
      } else {
        echo '<i class="fa fa-heart-o"></i> ';
      }
      echo  $article->like_count;
    ?>
      <p><?= $article->category ?> by <?= $article->author?></p>
      <p><?= $article->summary ?></p>
    </div>
  </div>