<?php
require_once '../config.php';
$userManager->redirectNonAdmin();
$id          = filter_input(INPUT_GET,'category_id', FILTER_VALIDATE_INT);
$action      = (isset($_GET['action'])       ? $_GET['action']       : 'create');
$name        = $_POST['name']        ?? '';
$description = $_POST['description']        ?? '';
$navigation  = (isset($_POST['navigation'])  ? 1 : 0);
$category    = new Category($id, $name, $description, $navigation);

$errors      = array('category_id' => '', 'name'=>'', 'description'=>'');

// Form not submitted
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    $category = ($id == '' ? $category : $categoryManager->getCategoryById($id));
    if ($category) {
        header('Location: ../page-not-found.php');
        exit;
    }
}

// Form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors['name'] = (Validate::isName($name, 1, 256) ? '' : $error_name);
    $errors['description'] = (Validate::isHTML($description, 1, 1000) ? '' : $error_text);

    if (strlen(implode($errors)) > 0) {                      // If data not valid
        $alert = '<div class="alert alert-danger">$error_form_correct</div>';
    }  else {                                                // If data valid
        if (strlen(implode($errors)) == 0) {
            if ($action == 'create') $result = $categoryManager->create($category);
            if ($action == 'update') $result = $categoryManager->update($category);
        }

        if (isset($result) && ($result === TRUE)) {
            $alert = "<div class=\"alert alert-success\">$action $alert_success</div>";
            $action = 'update';
        }
        if (isset($result) && ($result !== TRUE)) {
            $alert = "<div class=\"alert alert-danger\">$result</div>";
        }
    }
}

include 'includes/header.php';
?>
    <section>
        <h2><?=CMS::clean($action);?> category</h2>
        <?= $alert ?? '' ?>
        <form method="post" action="?action=<?=CMS::cleanLink($action) ?>&category_id=<?=CMS::cleanLink($category->category_id) ?>" >
            <div class="form-group">
                <label for="name">Name: </label>
                <input name="name" value="<?=CMS::clean($category->name)?>">
                <span class="errors"><?= $errors['name'] ?></span>
            </div>
            <div class="form-group">
                <label for="description">Description: </label>
                <textarea name="description" id="description" class="form-control">
       <?=CMS::clean($category->description); ?>
      </textarea>
                <span class="errors"><?= $errors['description'] ?></span>
            </div>
            <div class="form-group">
                <label for="navigation">Show in navigation: </label>
                <input type="checkbox" name="navigation" id="navigation" value="1"
                    <?php if ($category->navigation == 1) { echo 'checked'; } ?> >
            </div>
            <input type="submit" name="submit" value="save" class="btn btn-primary">
        </form>
    </section>
<?php include 'includes/footer.php'; ?>