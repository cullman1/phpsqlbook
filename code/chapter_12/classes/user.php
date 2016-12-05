<?php
class User {
 public  $id;
 public  $forename;
 public  $surname;
 public  $email;
 public  $password;
 public  $joined;
 public  $image;
 public $database;
 public $connection;
 public $authenticated;

 function __construct($id ='', $forename = NULL, $surname = NULL, $email = NULL, $password = NULL, $joined = NULL, $image = NULL, $authenticated = NULL) {
  if (is_null($authenticated)) {
    $this->database = Registry::instance()->get('database');   
    $this->connection =  $this->database->connection;   
  }
  $this->id       = ( isset($id)       ? $id       : '');
  $this->forename = ( isset($forename) ? $forename : '');
  $this->surname  = ( isset($surname)  ? $surname  : '');
  $this->email    = ( isset($email)    ? $email    : '');
  $this->password = ( isset($password) ? $password : '');
  $this->joined   = ( isset($joined)   ? $joined   : '');
  $this->image    = ( isset($image)    ? $image    : '');
  $this->authenticated    = ( isset($authenticated)    ? $authenticated    : '');
 }

 function create() {
  $sql = 'INSERT INTO user (forename, surname, email, password) 
          VALUES (:forename, :surname, :email, :password)';           // SQL
  $statement = $this->connection->prepare($sql);                           // Prepare
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
  $sql = 'UPDATE user SET forename = :forename, surname = :surname, email = :email WHERE id = :id';//SQL
   if ($this->image !="") {
      $sql = 'UPDATE user SET forename= :forename, surname = :surname, email= :email, image=:userimg where id= :id';    
  }
  $statement = $this->connection->prepare($sql);                           // Prepare
  $statement->bindValue(':forename', $this->forename);               // Bind value
  $statement->bindValue(':surname', $this->surname);                 // Bind value
  $statement->bindValue(':email', $this->email);                     // Bind value
  if ($this->image !="") {
    $statement->bindValue(':userimg', $this->image);               // Bind value
  }
   $statement->bindValue(':id', $this->id);   
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
   $result = $error->getCode() . ': ' . $error->getMessage(); // Error
  }
  return $result;                                                   // Say succeeded
 }


 function delete() {
                    // Connection
  $sql = 'DELETE FROM user WHERE id = :id';                      // SQL
  $statement = $this->connection->prepare($sql);                           // Prepare
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


}
?>