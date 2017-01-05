function submit_login($email, $password) {
  $connection = $GLOBALS['connection'];
  $user = get_user_by_email_passwordhash($email, $password); 

  if($user) {
    $_SESSION['login']    = $user->id; 
    $_SESSION['forename'] = $user->forename;
    $_SESSION['image']    = ($user->image ? $user->image : 'default.jpg');
    header('Location: index.php');
    exit;
  } 
  return array('status' => 'danger', 'message' =>'Login failed, please try again');
}

function get_user_by_email_passwordhash($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email AND password = :password';
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':password', $password);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_OBJ);
  if (!$user) { 
    return false;
  } else {
    return $user;
  }
}

function submit_logout() {
 $_SESSION = array();
 setcookie(session_name(),'', time()-3600, '/');
 header('Location: index.php');
}