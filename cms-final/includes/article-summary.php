  <div class="card" style="width:20rem; margin: 0.4rem;">
   <a href="<?= ROOT ?><?= $article->seo_category ?>/<?= $article->seo_title ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= $article->filename ?>" alt="<?= $article->alt ?>">
   </a>
    <div class="card-body text-center">
      <a href="<?= ROOT ?><?= $article->seo_category ?>/<?= $article->seo_title ?>">
        <h5 class="card-title"><?= $article->title?></h5>
      </a>
      <p><?= $article->summary ?></p>
      <p>
        Posted in <a href="<?= ROOT ?><?= $article->seo_category ?>"><?= $article->category ?></a>
        by <a href="<?= ROOT ?>users/<?= $article->seo_user ?>"><?= $article->author?></a>
      </p>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col">
          <?php
            if ($userManager->isLoggedIn() && $article->liked) {
              echo '<i class="fa fa-heart"></i> ';
            } else {
              echo '<i class="fa fa-heart-o"></i> ';
            }
          ?><?= $article->like_count ?>
        </div>
        <div class="col">
          <div class="text-right"><i class="fa fa-comment-o"></i> <?= $article->comment_count ?></div>
        </div>
      </div>
      <div class="row">
        <?php if ($my_profile) {
          echo '<div class="col"><a href="' . ROOT . 'users/update/' . $article->seo_title .'" class="btn btn-primary">edit</a></div>';
        } ?>
      </div>
    </div>
  </div>