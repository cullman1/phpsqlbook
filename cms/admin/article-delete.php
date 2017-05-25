<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB Connection
require_once('includes/class-lib.php');                          // Classes
require_once('includes/functions.php');                          // Classes

$id        = ( isset($_GET['id']) ? $_GET['id'] : '');              // Get id
$alert     = '';                                                    // Alert messages
$show_form = TRUE;                                                  // Show/hide form

// Got a number? Create a category object using function
if (filter_var($id, FILTER_VALIDATE_INT) != FALSE) {
  $Article  = get_article_by_id($id);
}
// Did you get a category object
if (!$Article) {
  $alert = '<div class="alert error">Cannot find article</div>';
}

if (!isset($_POST['confirm'])) {                           // Not submitted - load category data
  // Did you get a category object
  if ($Article) {
    $alert = '<div class="alert alert-danger">Please confirm you want to delete this information</div>';
  } else {
    $alert = '<div class="alert alert-danger">Cannot find article</div>';
    $show_form = FALSE;
  }

} else { // Submitted - try to delete

  $Article->id       = $id;                                // Set properties using form data
  $result = $Article->delete();

  if (isset($result) && ($result === TRUE)) {
    $alert = '<div class="alert alert-success">Category deleted</div>';
    $show_form = FALSE;
  }
  if (isset($result) && ($result !== TRUE)) {
    $alert = '<div class="alert alert-danger">Error: ' . $result . '</div>';
    $show_form = FALSE;
  }

}

include('includes/admin-header.php'); 
?>

<h2>Delete Article</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>
<form action="article-delete.php?id=<?= $id ?>" method="POST">
  Title: <?= $Article->title ?><br>
  Content: <?= $Article->content ?><br>
  Published: <?= $Article->published ?><br>
  <input type="submit" name="confirm" value="confirm delete" class="btn btn-primary">
</form>
<?php } else {
  include('includes/list-articles.php'); 
  }
  include('includes/admin-footer.php');
?>