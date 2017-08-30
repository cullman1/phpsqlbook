<?php
  require_once('includes/config.php');        // Connect
  class User {
  public $id;
  public $forename;
  public $surname;
  public $joined;
  public $image;
  public $fullname;

  public function __construct() {
    $this->fullname = $this->forename . '  ' . $this->surname;
   }

   public function getFullName() {
    return $this-forename . '  ' . $this-surname;
  }
  }
  $id = 1;     // category id

  // Get the name of the category and store in $category
  $sql = 'SELECT * FROM user WHERE id=:id'; // Query
  $statement = $pdo->prepare($sql);         // Prepare
  $statement->bindValue(':id', $id, PDO::PARAM_INT); // Bind value from query string
  $statement->execute();                             // Execute
 $user = $statement->fetchAll(PDO::FETCH_CLASS, 'User');     

  if (empty($user) || empty($user)) {
       header( "Location: 404.php" );
  }
?>

<!DOCTYPE html>
<html>
  <head>
    
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <?php  var_dump($user); ?>

      <div class="article">
    
        <span>Hello <?= $user->fullname ?></span>
      </div>


  </body>
</html>