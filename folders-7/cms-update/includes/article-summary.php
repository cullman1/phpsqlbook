  <div class="card article-summary">
   <a href="<?= ROOT . $article->seo_category ?>/<?= CMS::cleanLink($article->seo_title) ?>">
    <img class="card-img-top" src="<?= ROOT ?>uploads/<?= CMS::cleanLink($article->image_file) ?>" alt="<?=  CMS::clean($article->image_alt) ?>">
   </a>
    <div class="card-body text-center">
      <a href="<?= ROOT . CMS::cleanLink($article->seo_category) ?>/<?= CMS::cleanLink($article->seo_title) ?>">
        <h5 class="card-title"><?= CMS::clean($article->title)?></h5>
      </a>
      <p><?= $article->summary ?></p>
      <p>
        Posted in <a href="<?= ROOT .  CMS::cleanLink( $article->seo_category) ?>"><?=  CMS::cleanLink( $article->category) ?></a>
        by <a href="<?= ROOT ?>users/<?=  CMS::cleanLink( $article->seo_user) ?>"><?=  CMS::cleanLink( $article->author) ?></a>
      </p>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col">
          <?php
            if ($cms->userManager->isLoggedIn() && $article->liked) {
              echo '<i class="fa fa-heart"></i> ';
            } else {
              echo '<i class="fa fa-heart-o"></i> ';
            }
         echo CMS::clean( $article->like_count); ?>
        </div>
        <div class="col">
          <div class="text-right"><i class="fa fa-comment-o"></i> <?=  CMS::clean( $article->comment_count) ?></div>
        </div>
      </div>
      <div class="row">
        <?php if ($my_profile) {
          echo '<div class="col"><a href="' . ROOT . 'users/update/' .  CMS::cleanLink( $article->seo_title) .'" class="btn btn-primary">edit</a></div>';
        } ?>
      </div>
    </div>
  </div>