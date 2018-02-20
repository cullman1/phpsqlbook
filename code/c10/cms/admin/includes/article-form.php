<section>
  <h2 class="display-4 mb-4"><?=$action ?> article</h2><?= $alert ?? '' ?>
  <form method="post" action="?action=<?= CMS::cleanLink($action) ?>&article_id=<?= CMS::cleanLink($article->article_id) ?>">
    <div class="col-8">
      <div class="form-group">
        <label for="title">Title: </label>
        <input name="title" value="<?= CMS::clean($article->title) ?? '' ?>">
        <span class="error"><?= $errors['name'] ?? '' ?></span>
      </div>
      <div class="form-group">
        <label for="summary">Summary: </label>
        <textarea name="summary" id="summary" class="form-control"><?= CMS::clean($article->summary) ?? '' ?></textarea>
        <span class="errors"><?= $errors['summary'] ?? '' ?></span>
      </div>
      <div class="form-group">
        <label for="content">Content: </label>
        <textarea name="content" id="content" class="form-control">
     <?= CMS::clean($article->content) ?></textarea>
        <span class="errors"><?= $errors['content'] ?? '' ?></span>
      </div>
      <div class="form-group">
        <label for="category_id">Category:  </label>
        <select name="category_id" id="category_id" class="form-control">
          <?php foreach ($category_list as $category) { ?>
            <option value="<?= $category->category_id ?>"
              <?php if ($article->category_id == $category->category_id) {
                echo 'selected';
              } ?> >
              <?= $category->name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label for="user_id">Author: </label>
        <select name="user_id" id="user_id" class="form-control">
          <?php foreach ($user_list as $user) { ?>
            <option value="<?= $user->user_id ?>"
              <?php if ($article->user_id == $user->user_id) {
                echo 'selected';
              } ?> ><?= $user->getFullName(); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-check-label">
          <input type="checkbox" name="published" value="1" class="form-check-input"
            <?php if ($article->published == '1') {echo 'checked';} ?>> Published </label>
      </div>
    </div>
    <input type="submit" name="create" value="save" class="btn btn-primary">
  </form>
</section>