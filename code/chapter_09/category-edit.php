<?php
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';

// What should the page be doing?
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' ); 

// Setup  article object and get values from  form if supplied
$category = init_category(); 

switch ($action) {                  // Choose what to do based on action
	case 'add':                     // User wants to add a category
		$action = 'create';         // Set action to insert
		break;

	case 'create':                  // User wants to insert new category
		$message = insert_category($category->name, $category->template);
		$action  = 'update';        // Set action to update once updated
		break;

	case 'edit':                    // User wants to edit article
		$category = get_category_by_id($category->id);
		$action  = 'update';        // Set action to update
		break;

	case 'update':
	    if ( isset($category->id) ) {
	      $message = update_category($category->d, $category->name, $category->template);
	    } else {
	      $message = '<div class="error">Could not update category</div>';
	    }
		$category   = get_category_by_id($category->id);
    	break;	

	case 'delete':
    	if ( isset($category->id) ) {
    	  $message = delete_category($category->id);
    	} else {
    	  $message = '<div class="error">Could not delete category</div>';
    	}
        $action = 'add';
	    break;

	default:
		header('location: category-list.php');
		break;
}
// Update the query string with new action, and current article id if available
$querystring = '?action=' . $action . '&category_id=' . $category->id;

include 'includes/header.php';
?>

<?=$message;?>

<div class="panel">

<h2><?=$action;?> category</h2>
<div class="col-2">
  <form action="<?=$querystring;?>" method="post">
    <label>Category name:</label> <input type="text" name="name" value="<?= htmlspecialchars($category->name); ?>"><br>
    <label>Template file:</label> <input type="text" name="template" value="<?= htmlspecialchars($category->template); ?>"><br>
    <input type="submit" value="save category" class="button save">
</form>
</div>

</div>
<?php include 'includes/footer.php'; ?>