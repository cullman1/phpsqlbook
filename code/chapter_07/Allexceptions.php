<?php require_once('../chapter_08/includes/database-connnection-new.php'); 
function get_user_details_form(){
  $form = '<form method="post" action="" ><label>Title: <input type="text" name="title" /></label><br/><br/>
    <label>Category: <input type="text" name="cat" /></label><br/><br/>
    <label>Email: <input type="text" name="email"  /></label><br/><br/>
    <label>Role: <input type="text" name="role"  /></label><br/><br/<br/>
    <button type="submit" name="submitted" value="sent">Submit</button></form>';
  return $form;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
try {
 if (!isset($_POST["title"])) { $query = "Insert into article (title) values (NULL)"; } 
 if ($_POST["cat"] != "info") { $query="Insert into category (name) values ('News')"; }
 if ($_POST["role"] != "1" ) { $query = "Insert into user (role_id) values (3)"; }
 if ($_POST["email"] == "bob@test.com" ) { $query = "Insert into user (id) values (3)";}
echo $query;  
$statement = $GLOBALS['connection']->prepare($query);
  $statement->execute(); 
}
catch (PDOException $e) {
  echo "An error has occurred: " . $e; 
}
} else {
echo get_user_details_form();
} ?>
