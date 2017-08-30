<?php

echo "/* Article functions (10) 

function get_article_by_seo_title($title) {
  $query = 'SELECT article.*, category.name, category.seo_name,
      user.id AS user_id, user.forename, user.surname, user.email, user.image,
      media.filepath, media.filename, media.alt, media.mediatype, media.thumb '; 
 
    }
}

function get_article_list_by_category_name($name, $show='', $from='') {
  $query = 'SELECT article.id, article.title, article.media_id, article.published, article.seo_title,article.like_count, article.comment_count,
      media.id as media_id, media.filepath, media.thumb, media.alt, media.mediatype ';
 
   
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      LEFT JOIN user ON article.user_id = user.id
    
      ORDER BY article.published ASC';                 // Query
    
     
      $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ); 
      $article_list = $statement->fetchAll();
      return $article_list;
}

function get_article_count() {
  $query = 'SELECT count(*) from article
      WHERE published <= now()
      ORDER BY article.published ASC';                 // Query
     
      $count= $statement->fetchColumn();
      return $count;
}


function get_article_count_by_category_name($name, $show='', $from='') {
 
  $query = 'SELECT count(*)
      FROM article
      LEFT JOIN category ON article.category_id = category.id
      WHERE published <= now()   
      AND category.name=:name 
      ORDER BY article.published ASC';                 // Query
  $statement = $connection->prepare($query);
  $statement->bindValue(':name', $name);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
  $count = $statement->fetchColumn();
  return $count;
}

function get_article_count_by_category_seo_name($name, $show='', $from='') {

  $query = 'SELECT count(*)
      FROM article
      LEFT JOIN category ON article.category_id = category.id
      WHERE published <= now()   
      AND category.name=:name 
      ORDER BY article.published ASC';                 // Query
  $statement = $connection->prepare($query);
  $statement->bindValue(':name', $name);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
  $count = $statement->fetchColumn();
  return $count;
}

function get_category_by_seo_name($seo_name) {

    $query = 'SELECT category.description, category.name, category.seo_name
      FROM article
      LEFT JOIN category ON article.category_id = category.id
      WHERE published <= now()   
      AND category.name=:seo_name';            // Query
  $statement = $connection->prepare($query);          // Prepare
  $statement->bindValue(':seo_name', $seo_name);    // Bind value from query string
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Category');
    $Category = $statement->fetch();
  }
  if ($Category) {
    return $Category;
  } else {
    return FALSE;
  }
}


function get_article_list_by_author_name($forename, $surname, $show='', $from='') {
 
  $query = 'SELECT  category.*, media.*, user.*, article.* ';

     $query .= ',(select likes.user_id from likes where likes.user_id= ' . 
               
  }
  $query .= 'FROM article
      JOIN user ON article.user_id = user.id
      JOIN category ON article.category_id = category.id
      JOIN media ON article.media_id = media.id
      WHERE published <= now()  AND user.forename=:forename 
      AND user.surname=:surname ORDER BY article.published ASC';                 
 
  $statement = $connection->prepare($query);
  $statement->bindValue(':forename', $forename);  
  $statement->bindValue(':surname', $surname); 
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $article_list = $statement->fetchAll();
  return $article_list;
}

function get_article_count_by_author_name($forename, $surname, $show='', $from='') {
 
  $query = 'SELECT count(*) FROM article
      LEFT JOIN user ON article.user_id = user.id
      WHERE published <= now() AND user.forename=:forename 
     AND user.surname=:surname  ORDER BY article.published ASC';               
  $statement = $connection->prepare($query);
  $statement->bindValue(':forename', $forename);  
  $statement->bindValue(':surname', $surname); 
  $statement->execute();

  $count = $statement->fetchColumn();
  return $count;
}

function get_articles_by_search($search, $show='', $from='', $sort='', $dir='ASC',  $user='0') {
   $query = 'SELECT  category.*, user.*,  article.* ';
 
  $query .= 'FROM article
             JOIN user ON user.id = user_id 
             JOIN category ON category.id= category_id where published <= now()';
 
  //If user id not 0, add user id clause
  if ($user > 0) {     
    $query .= ' AND user.id = :id';
  }
  //If sort not empty, add a sort
  
 
  //If user id not 0 bind parameter
  if ($user > 0) {          

  }


  if (!empty($search)) { 
  
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $article_list = $statement->fetchAll();  
  //If search not empty, highlight search term
  if (!empty($search) && !empty($show)) { 
      foreach($article_list as $article) {
     
      }
  }
  return $article_list;
}

function get_article_count_by_search($search, $user='0') {

  //If user id not 0, add user id clause
  if ($user > 0) {     
    $query .= ' AND user.id = :id';
  }
 
 
  //If user id not 0 bind parameter
  if ($user > 0) {          
  
  }
  if (!empty($search)) { 
  
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $count = $statement->fetchColumn();  
  return $count;
}

function get_article_url($article_id) {
  $query = 'SELECT category.seo_name, article.seo_title FROM article
            LEFT JOIN category ON article.category_id = category.id
            WHERE article.id=:id';
 
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_OBJ);     
    $titles = $statement->fetch();
  }
  if ($titles) {
    return $titles->seo_name . '/' . $titles->seo_title;
  } else {
    return FALSE;
  }
}

/* User functions (6)  

function get_user_by_id($id) {
	
	$query = 'SELECT * FROM user WHERE id=:id';             // Query
	$statement = $connection->prepare($query);              // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);      // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_OBJ); // Object
		$User = $statement->fetch();                        // Fetch
	}
	if ($User) {
		return $User;
	} else {
	    return FALSE;
    }
}

function get_user_list() {
  
  $query = 'SELECT * FROM user';
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ); 
  $user_list = $statement->fetchAll();        
  return $user_list;
}

function check_user() {
 
}

function get_user_by_email($email) {
  $sql = 'SELECT * from user WHERE email = :email';

  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : FALSE);
}

function get_user_by_email_password($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';

  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
    $user = $statement->fetch();
  }
  if (!$user) { 
    return FALSE; 
  }
  return (password_verify($password, $user->password) ? $user : FALSE);
}

function create_user_session($user) {
 

/* Like functions (2) 

function add_like_by_id($user_id, $article_id) {
  try {
   
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();
    $query= 'UPDATE article SET like_count = like_count + 1 WHERE id = :article_id';
  
    $statement->bindValue(':article_id', $article_id);
    $statement->execute();

    return TRUE;
  } catch (PDOException $error) {
   
    return 'Article ' .$article_id . ' was not liked. Error: ' . $error->getMessage();
  }
}

function remove_like_by_id($user_id, $article_id) {
  try {
   
    $query = 'DELETE FROM likes WHERE user_id= :user_id AND article_id= :article_id';               
   
    $statement->bindValue(':user_id', $user_id);  
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
    $query = 'UPDATE article SET like_count = like_count - 1 WHERE id = :article_id';
   
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
  
    return TRUE;
  } catch (PDOException $error) {                               
   
    return 'Article ' .$article_id . ' was not unliked. Error: ' . $error->getMessage();
  }
}

/* Comment functions (1)

function get_comments_by_article_id($id) {
 
            user.image,  comment.* FROM comment 
            JOIN user ON comment.user_id = user.id   
            WHERE article_id = :id 
            ORDER BY posted ASC';  
 
  $statement->bindValue(':id', $id, PDO::PARAM_INT); 
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');
  $comments_list = $statement->fetchAll(); 

  if ($comments_list) {
    return $comments_list;
  } else {
    return FALSE; 
  }
}

/* Nested comments (3) */

function get_nested_comments_by_article_id($id) {
 
          JOIN user ON comment.user_id = user.id   
          WHERE comment.id = reply_to_name ) as reply_to_name
FROM comment 
JOIN user ON comment.user_id = user.id   
WHERE article_id = :id 
ORDER BY posted ASC';  
 
  $statement->bindValue(':id', $id, PDO::PARAM_INT);      
$statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');     // Object
    $commentslist = $statement->fetchAll();
  if ($commentslist) {
    return $commentslist;
  } else {
    return FALSE; 
  }
}

function get_comments_and_replies_by_article_id($id) {
  $query = 'SELECT comment.*, comment.reply_to_id AS reply_to_copy,
     
                    JOIN comment ON user.id = comment.user_id
                    WHERE comment.id = reply_to_copy) 
            AS reply_to
            FROM comment
            JOIN user ON comment.user_id = user.id 
            WHERE article_id = :id 
            ORDER BY posted DESC';

  $statement->bindValue(':id', $id, PDO::PARAM_INT);      
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');          
  $comments_list = $statement->fetchAll();
  if ($comments_list) {
    return $comments_list;
  } else {
    return FALSE; 
  }
}

function sort_comments($comment_list) {
    $comment_list_reversed = array_reverse($comment_list);
    $nested_comments       = array();
    foreach ($comment_list as $comment) {
      if ($comment->parent_id == 0) {
        array_push($nested_comments, $comment);
        foreach ($comment_list_reversed as $reply) {
          if ($reply->parent_id == $comment->id) {
            array_push($nested_comments, $reply);
          }
        }
      }
    }
    return $nested_comments;
  }


/* Miscellaneous functions (5) 

function get_menu() {
    $categorylist = new CategoryList(get_category_list());
    $list = '';
    foreach($categorylist->categories as $category) {
     
    }
    return $list;
}

function format_date($datetime) {
    if (!empty($datetime)) {
	$date = date_create_from_format('Y-m-d H:i:s', $datetime);
 
    return $date->format('F d Y');
    }
    else {
   
    }
}

function get_category_list() {
  $query = 'SELECT * FROM category'; // Query
 
  $statement->execute(); 
   $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display

  return $category_list;
}

function create_slug($title) {
    $title = strtolower($title);
    $title = trim($title);
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
}

function create_pagination($count, $show, $from, $search='') {
  $total_pages  = ceil($count / $show);   // Total matches
  $current_page = ceil($from / $show) + 1;    // Current page

 
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        $result .= $i . '&nbsp;';
      } else {
    
         if (isset($search)) {
         $result .= '&term='.$search; 
        }
     
       }
    }
  }
 
}

/* Third party functions (2) */

function send_email($to, $subject, $message) {
  try {                                                      // Start a try block
    // Step 1: Create the object
    $mail = new PHPMailer(TRUE);                             // Create object
    // Step 2: How the email is going to be sent
    $mail->IsSMTP();                                         // Set mailer to use SMTP
    $mail->Host     = 'smtp.example.com';                    // SMTP server address
    $mail->SMTPAuth = TRUE;                                  // SMTP authentication on
    $mail->Username = 'chris@example.com';                   // Username
    $mail->Password = 'password';                            // Password
    // Step 3: Who the email is from and to
    $mail->setFrom('no-reply@example.com');                  // From email address
    $mail->AddAddress($to);                                  // To email address
    // Step 4: Content of email  
    $mail->Subject = $subject;                               // Set subject of email
    $mail_header   = '<!DOCTYPE html PUBLIC...';             // Header goes here
    $mail_footer   = '...</html>';                           // Footer goes here
    $mail->Body    = $mail_header . $message . $mail_footer; // Set body of HTML email  
    $mail->AltBody = strip_tags($message);                   // Set plain text body
    $mail->CharSet = 'UTF-8';                                // Set character set
    $mail->IsHTML(TRUE);                                     // Set as HTML email
    // Step 5: Attempt to send email                                 
    $mail->Send();                                     // Send the email
  } catch (phpmailerException $error) {                // Code to run if failed to send
    return $error->errorMessage();                     // Return PHPMailer error message
  } 
  return TRUE;                                         // Return TRUE because it sent
}

function time_elapsed($datetime) {
    $now = new DateTime;
  
    $diff = $now->diff($old_time);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}";

?>