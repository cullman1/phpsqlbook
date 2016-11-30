<?php
Class User {
 public  $id;
 public  $forename;
 public  $surname;
 public  $email;
 public  $password;
 public  $joined;
 public  $image;
 public $database;
 public $authenticated;

 function __construct($database, $id ='', $forename = NULL, $surname = NULL, $email = NULL, $password = NULL, $joined = NULL, $image = NULL, $authenticated = NULL) {
  $this->id       = ( isset($id)       ? $id       : '');
  $this->forename = ( isset($forename) ? $forename : '');
  $this->surname  = ( isset($surname)  ? $surname  : '');
  $this->email    = ( isset($email)    ? $email    : '');
  $this->password = ( isset($password) ? $password : '');
  $this->joined   = ( isset($joined)   ? $joined   : '');
  $this->image    = ( isset($image)    ? $image    : '');
  $this->authenticated    = ( isset($authenticated)    ? $authenticated    : '');
  $this->database = ( isset($database)       ? $database       : '');
 }

 function create() {
  $sql = 'INSERT INTO user (forname, surname, email, password) 
          VALUES (:forname, :surname, :email, :password)';           // SQL
  $statement = $this->database->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':forename', $this->forename);               // Bind value
  $statement->bindValue(':surname', $this->surname);                 // Bind value
  $statement->bindValue(':email', $this->email);                     // Bind value
  $statement->bindValue(':password', $this->password);               // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
   $result = $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
  }
  return $result;                                                   // Say succeeded
 }

 function update() {                           // Connection
  $sql = 'UPDATE category SET forename = :forename, surname = :surname, email = :email, password = :password, WHERE id = :id';//SQL
  $statement = $this->database->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':forename', $this->forename);               // Bind value
  $statement->bindValue(':surname', $this->surname);                 // Bind value
  $statement->bindValue(':email', $this->email);                     // Bind value
  $statement->bindValue(':password', $this->password);               // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
   $result = $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
  }
  return $result;                                                   // Say succeeded
 }

 function delete() {
                    // Connection
  $sql = 'DELETE FROM user WHERE id = :id';                      // SQL
  $statement = $this->database->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
  if($statement->execute()) {                                        // If executes
   return TRUE;                                                   // Say succeeded
  } else {                                                           // Otherwise
   return $statement->errorCode() . ': ' . $statement->errorInfo(); // Error
  }
 }

  public function getFullName() {
        return $this->forename . ' ' . $this->surname;
    }

 public function getById($id) { 
  $query = "select article.*, user.* FROM article JOIN user ON article.user_id = user.id JOIN category ON article.category_id = category.id where article.id= :article_id";
 $statement = $this->database->connection->prepare($query);
 $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_OBJ);
 $user = $statement->fetchAll();  
     if (isset($user)) {
		    	$this->id 		= $user[0]->{'user.id'};
		    	$this->forename 	= $user[0]->{'user.forename'};
		    	$this->surname = $user[0]->{'user.surname'};
                $this->email = $user[0]->{'user.email'};
                $this->password = $user[0]->{'user.password'};
                $this->joined = $user[0]->{'user.joined'};
                $this->image = $user[0]->{'user.image'};
                                            $this->authenticated = $user[0]->{'user.id'};
			}

 return $user;
}
}
?>