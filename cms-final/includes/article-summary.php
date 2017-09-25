  <div class="card article-summary">
   <a href="<?= ROOT ?><?= $article->seo_category ?>/<?= htmlentities($article->seo_title, ENT_QUOTES, 'UTF-8') ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= htmlentities($article->filename, ENT_QUOTES, 'UTF-8') ?>" alt="<?=  htmlentities($article->alt, ENT_QUOTES, 'UTF-8') ?>">
   </a>
    <div class="card-body text-center">
      <a href="<?= ROOT ?><?= $article->seo_category ?>/<?= htmlentities($article->seo_title, ENT_QUOTES, 'UTF-8') ?>">
        <h5 class="card-title"><?= htmlentities($article->title, ENT_QUOTES, 'UTF-8')?></h5>
      </a>
      <p><?= $article->summary ?></p>
      <p>
        Posted in <a href="<?= ROOT ?><?=  htmlentities( $article->seo_category, ENT_QUOTES, 'UTF-8') ?>"><?=  htmlentities( $article->category, ENT_QUOTES, 'UTF-8') ?></a>
        by <a href="<?= ROOT ?>users/<?=  htmlentities( $article->seo_user, ENT_QUOTES, 'UTF-8') ?>"><?=  htmlentities( $article->author, ENT_QUOTES, 'UTF-8')?></a>
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
          ?><?=  htmlentities( $article->like_count, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <div class="col">
          <div class="text-right"><i class="fa fa-comment-o"></i> <?=  htmlentities( $article->comment_count, ENT_QUOTES, 'UTF-8') ?></div>
        </div>
      </div>
      <div class="row">
        <?php if ($my_profile) {
          echo '<div class="col"><a href="' . ROOT . 'users/update/' .  htmlentities( $article->seo_title, ENT_QUOTES, 'UTF-8') .'" class="btn btn-primary">edit</a></div>';
        } ?>
      </div>
    </div>
  </div>