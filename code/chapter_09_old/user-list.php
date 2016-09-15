<?php
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';
$user_list = get_user_list();

include 'includes/header.php';
?>


<?=$message?>

<div class="panel">
  <div class="new"><a href="user-edit.php?action=add" class="button">Add user</a></div>

<table>
  <tr>
    <th>Profile picture</th><th>ID</th><th>Name</th><th>Email</th><th>Date Joined</th><th></th><th></th>
  </tr>
  <?php foreach ($user_list as $user) { ?>
  <tr>
    <td><?=$user->picture;?></td>
    <td><?=$user->id;?></td>
    <td><?=$user->name;?></td>
    <td><?=$user->email;?></td>
    <td><?=$user->joined;?></td>
    <td><a href="user-edit.php?action=edit&user_id=<?=$user->id;?>" class="button">edit</a></td>
    <td><a href="user-edit.php?action=delete&user_id=<?=$user->id;?>" class="button confirmation">delete</a></td>
  </tr>
    <?php } ?>
</table>
</div>
<?php include 'includes/footer.php'; ?>