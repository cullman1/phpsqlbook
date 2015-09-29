<?php class DbHandler{   
 public function getArticleById($pdo, $id ) {
 $query = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id= :id";
  $statement = $pdo->prepare($query);
  $statement->bindParam(":id", $id);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  return $statement;
    }

 public function getArticleByName($pdo, $title) {
  $new_title = str_replace("-"," ", trim($title[0]));
  $query = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id =  category.category_id where title=:title";
  $statement = $pdo->prepare($query);
  $statement->bindParam(":title", $new_title);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  return $statement;
 }

  public function getArticleList($pdo) {
 $query= "select article_id, title, content, category_name, category_template, full_name, date_posted, role_id, parent_name, article.parent_id, template FROM article  JOIN user ON article.user_id = user.user_id  JOIN parent ON article.parent_id = parent.parent_id JOIN category ON article.category_id = category.category_id where date_published <= now() order by article_id DESC";
  $statement = $pdo->prepare($query);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  return $statement;
}

public function getAuthorName($pdo, $id) { 
  $query = "select user.user_id, full_name FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id= :article_id";
 $statement = $pdo->prepare($query);
 $statement->bindValue(':article_id', $id, PDO::PARAM_INT);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 return $statement;
}
  
 public function getSearchResults($pdo) {
 $trim_search = trim($_GET["search"]);
 $searchterm = "AND ((title like '%" .$trim_search. "%')";
  $searchterm .= "OR (content like '%".$trim_search. "%'))";
  $query =  "select article_id, title, content, date_posted 
  FROM article";
 $query .= "where date_published <= now() " . $searchterm .  
  "order by article_id DESC";
  $statement = $pdo->prepare($query);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_BOTH); 
  return $statement;
 }

public function getAllLikes($pdo, $user_id,$article_id) {
  $query = "select distinct :artid as articleid, :userid as userid, (select count(*) as likes FROM article_like where article_id=:artid and user_id=:userid ) as likes_count, (select count(article_id) as likes FROM article_like where article_id=:artid) as likes_total FROM article_like as a right outer join (select article_id FROM article where article_id=:artid) as b ON (b.article_id = a.article_id) where b.article_id=:artid"; 
  $statement = $pdo->prepare($query);
  $statement->bindParam(':artid', $article_id);
  $statement->bindParam(':userid',$user_id);
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC);  
  return $statement;
}

public function getProfile($pdo, $user_id) {
 $query = "select * FROM user where user_id=:userid";
 $statement = $pdo->prepare($query);
 $statement->bindParam(':userid',$user_id);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 return $statement;
}

public function setProfile($pdo, $id, $name, $email, $status, $img)
{
$query = 'UPDATE user SET full_name= :name, email= :email,  user_status= :status'.$img.'  where user_id= :userid';
 $statement = $pdo->prepare($query);
 $statement->bindParam(':userid',$id);
  $statement->bindParam(':name',$name);
   $statement->bindParam(':email',$email);
    $statement->bindParam(':status',$status);
    if(isset($img)) {
     //$statement->bindParam(':userimg',$img);
     }
     $statement->execute();
      if($statement->errorCode() != 0) { return "1"; }
      else { return "0";}
}


} ?>