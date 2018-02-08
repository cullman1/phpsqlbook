<?php
class UserManager {
  
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

    public function getUserById($id) :?User {
    $pdo = $this->pdo;
    $sql = 'SELECT user.user_id, user.forename, user.surname, user.joined, user.email, user.picture
            FROM user 
            WHERE user_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetch();
    return $user ?: NULL;
  }

}