<?php
require_once('../includes/database-connection.php'); 
require_once('includes/functions.php'); 
$message = '';

// What should the page be doing?
$action  = ( isset($_GET['action'])   ? $_GET['action']   : '' ); 


// Setup  article object and get values from  form if supplied
$user = init_user(); 

switch ($action) {                  // Choose what to do based on action
	case 'add':                     // User wants to add a category
		$action = 'create';         // Set action to insert
		break;

	case 'create':                  // User wants to insert new category
		$message = insert_user($user->name, $user->email, $user->password, $user->picture); //this
		$action  = 'update';        // Set action to update once updated
		break;

	case 'edit':                    // User wants to edit article
		$user = get_user_by_id($user->id);
		$action  = 'update';        // Set action to update
		break;

	case 'update':
	    if ( isset($user->id) ) {
	      $message = update_user($user->id, $user->name, $user->email, $user->password, $user->picture);
	    } else {
	      $message = '<div class="error">Could not update user</div>';
	    }
		$category   = get_user_by_id($user->id);
    	break;	

	case 'delete':
    	if ( isset($user->id) ) {
    	  $message = delete_user($user->id);
    	} else {
    	  $message = '<div class="error">Could not delete user</div>';
    	}
        $action = 'add';
	    break;

	default:
		header('location: user-list.php');
		break;
}
// Update the query string with new action, and current article id if available
$querystring = '?action=' . $action . '&user_id=' . $user->id;

include 'includes/header.php';
?>

<?=$message;?>

<div class="panel">

<h2><?=$action;?> user</h2>
<div class="col-2">
  <form action="<?=$querystring;?>" method="post">
    <label>Name:</label> <input type="text" name="name" value="<?= htmlspecialchars($user->name); ?>"><br>
    <label>Email:</label> <input type="text" name="email" value="<?= htmlspecialchars($user->email); ?>"><br>
    <label>Password:</label> <input type="text" name="password" value="<?= htmlspecialchars($user->password); ?>"><br>
    <label>Profile:</label> <input type="text" name="profile" value="<?= htmlspecialchars($user->picture); ?>"><br>
    <input type="submit" value="save user" class="button save">
</form>
</div>

</div>

<?php include 'includes/footer.php'; ?>