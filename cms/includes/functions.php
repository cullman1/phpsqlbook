<?php

/* Article functions */

function get_article_by_seo_title($seo_title) {
    // This had conflicts for the id colum in article and user
    $connection = $GLOBALS['connection'];
    $query = 'SELECT  category.*, media.*, user.*,  article.*';
  if (isset($_SESSION["user_id"])) {
    $query .=',(select likes.user_id from likes where  likes.user_id=  ' . $_SESSION["user_id"] .'    and likes.article_id = article.id) as liked ';
  }     
  $query .= 'FROM article
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
      LEFT JOIN category ON article.category_id = category.id
      WHERE article.seo_title=:seo_title';           // Query
    $statement = $connection->prepare($query);          // Prepare
    $statement->bindValue(':seo_title', $seo_title);    // Bind value from query string
    if ($statement->execute() ) {
        $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary');     // Object
        $Article = $statement->fetch();
    }
    if ($Article) {
        return $Article;
    } else {
        return FALSE;
    }
}

function get_article_list($show='', $from='') {
  $query = 'SELECT  category.*, media.*, user.*,  article.*';
  if (isset($_SESSION["user_id"])) {
    $query .=',(select likes.user_id from likes where  likes.user_id=  ' . $_SESSION["user_id"] .'    and likes.article_id = article.id) as liked ';
  }     
  $query .= 'FROM article
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      LEFT JOIN user ON article.user_id = user.id
      WHERE published <= now() and category.template != "general"
      ORDER BY article.published ASC';                 // Query
      if (!empty($show)) {
        $query .= " limit " . $show . " offset " . $from;
      }
      $statement = $GLOBALS['connection']->prepare($query);
      $statement->execute();
      $statement->setFetchMode(PDO::FETCH_OBJ); 
      $article_list = $statement->fetchAll();
      return $article_list;
}

function get_article_count() {
  $query = 'SELECT count(*) from article
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      LEFT JOIN user ON article.user_id = user.id
      WHERE published <= now()
      ORDER BY article.published ASC';                 // Query
      $statement = $GLOBALS['connection']->prepare($query);
      $statement->execute();
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); // Needs to be ArticleList class
      $count= $statement->fetchColumn();
      return $count;
}

function get_article_list_by_category_name($name, $show='', $from='') {
  $connection = $GLOBALS['connection'];
  $query = 'SELECT  category.*, media.*, user.*,  article.* ';
 if (isset($_SESSION["user_id"])) {
     $query .= ',(select likes.user_id from likes where likes.user_id= ' . 
                $_SESSION["user_id"] .' and likes.article_id = article.id) as liked ';
  }
  $query .= 'FROM article
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
         LEFT JOIN user ON article.user_id = user.id
      WHERE published <= now()   
      AND category.name=:name 
      ORDER BY article.published ASC';                 // Query

 //Get limited page of articles
  if (!empty($show)) {
    $query .= " limit " . $show . " offset " . $from;
  }
  $statement = $connection->prepare($query);
  $statement->bindValue(':name', $name);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $article_list = $statement->fetchAll();
  return $article_list;
}

function get_article_count_by_category_name($name, $show='', $from='') {
  $connection = $GLOBALS['connection'];
  $query = 'SELECT count(*)
      FROM article
      LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
         LEFT JOIN user ON article.user_id = user.id
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

function get_article_list_by_author_name($forename, $surname, $show='', $from='') {
  $connection = $GLOBALS['connection'];
   $query = 'SELECT  category.*, media.*, user.*, article.* ';
 if (isset($_SESSION["user_id"])) {
     $query .= ',(select likes.user_id from likes where likes.user_id= ' . 
                $_SESSION["user_id"] .' and likes.article_id = article.id) as liked ';
  }
  $query .= 'FROM article
      LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE published <= now() 
        AND user.forename=:forename 
  AND user.surname=:surname 
ORDER BY article.published ASC';                 // Query
 //Get limited page of articles
  if (!empty($show)) {
    $query .= " limit " . $show . " offset " . $from;
  }
  $statement = $connection->prepare($query);
  $statement->bindValue(':forename', $forename);  // Bind value from query string
    $statement->bindValue(':surname', $surname);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $article_list = $statement->fetchAll();
  return $article_list;
}

function get_article_count_by_author_name($forename, $surname, $show='', $from='') {
  $connection = $GLOBALS['connection'];
  $query = 'SELECT count(*) 
      FROM article
      LEFT JOIN user ON article.user_id = user.id
            LEFT JOIN category ON article.category_id = category.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE published <= now() 
        AND user.forename=:forename 
  AND user.surname=:surname 
ORDER BY article.published ASC';                 // Query
  $statement = $connection->prepare($query);
  $statement->bindValue(':forename', $forename);  // Bind value from query string
    $statement->bindValue(':surname', $surname);  // Bind value from query string
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $count = $statement->fetchColumn();
  return $count;
}

function get_articles_by_search($search, $show='', $from='', $sort='', $dir='ASC',  $user='0') {
   $query = 'SELECT  category.*, user.*,  article.* ';
 if (isset($_SESSION["user_id"])) {
     $query .= ',(select likes.user_id from likes where likes.user_id= ' . 
                $_SESSION["user_id"] .' and likes.article_id = article.id) as liked ';
  }
  $query .= 'FROM article
JOIN           user ON user.id = user_id JOIN category ON 
      category.id= category_id where published <= now()';
  $search_wildcards = "%". trim($search) . "%"; 
  //If search with wildcards  
  if (!empty($search)) {   
    $searchsql = " AND ((title like :search)";
    $searchsql .= " OR (content like :search))";
    $query .= $searchsql;   
  }
  //If user id not 0, add user id clause
  if ($user > 0) {     
    $query .= ' AND user.id = :id';
  }
  //If sort not empty, add a sort
  if (!empty($sort)) {    
    $query .= " Order By " . $show . " " . $dir;
  }
  //Get limited page of articles
  if (!empty($show)) {  
    $query .= " limit " . $show . " offset " . $from;
  }
  $statement =$GLOBALS['connection']->prepare($query);
  //If user id not 0 bind parameter
  if ($user > 0) {          
    $statement->bindParam(":id", $user);    
  }


  if (!empty($search)) { 
    $statement->bindParam(":search", $search_wildcards);
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary'); 
  $article_list = $statement->fetchAll();  
  //If search not empty, highlight search term
  if (!empty($search) && !empty($show)) { 
      foreach($article_list as $article) {
          $article->content =preg_replace('/'.$search.'/i', '<span class="highlight">$0</span>',    $article->content); 
      }
  }
  return $article_list;
}

function get_article_count_by_search($search, $user='0') {
  $query= "SELECT count(*) FROM article JOIN
           user ON user.id = user_id JOIN category ON 
      category.id= category_id where published <= now()";
  $search_wildcards = "%". trim($search) . "%"; 
  //If search with wildcards  
  if (!empty($search)) {   
    $searchsql = " AND ((title like :search)";
    $searchsql .= " OR (content like :search))";
    $query .= $searchsql;   
  }
  //If user id not 0, add user id clause
  if ($user > 0) {     
    $query .= ' AND user.id = :id';
  }
 
  $statement =$GLOBALS['connection']->prepare($query);
  //If user id not 0 bind parameter
  if ($user > 0) {          
    $statement->bindParam(":id", $user);    
  }


  if (!empty($search)) { 
    $statement->bindParam(":search", $search_wildcards);
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $count = $statement->fetchColumn();  
  return $count;
}

/* User functions */

function get_user_by_id($id) {
	$connection = $GLOBALS['connection'];
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
  $connection = $GLOBALS['connection'];
  $query = 'SELECT * FROM user';
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ); 
  $user_list = $statement->fetchAll();        
  return $user_list;
}

function check_user() {
 if (!isset($_SESSION['user_id'])) { 
  return "0";
 }
 return $_SESSION['user_id'];
}

function get_user_by_email($email) {
  $sql = 'SELECT * from user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($sql);
  $statement->bindParam(':email', $email);
  if ($statement->execute() ) {
    $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');            
    $user = $statement->fetch();
  }
  return ($user ? $user : FALSE);
}

function get_user_by_email_password($email, $password) {
  $query = 'SELECT * FROM user WHERE email = :email';
  $statement = $GLOBALS['connection']->prepare($query);
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
  $_SESSION['name']    = $user->forename . ' ' . $user->surname;
  $_SESSION['user_id'] = $user->id;
}

/* Like functions */

function get_like_button($likes, $user_id, $article_id) {
  if (isset($likes)) {
     return '<a href="/phpsqlbook/cms/unlike?user_id='.$user_id.'&article_id='.$article_id.'"><i class="fa fa-heart" aria-hidden="true"></i></a> ';
  } else {
    return '<a href="/phpsqlbook/cms/like?user_id='.$user_id.'&article_id='.$article_id.'"><i class="fa fa-heart-o" aria-hidden="true"></i></a> ';
  }
}

function add_like_by_id($user_id, $article_id) {
  try {
    $GLOBALS['connection']->beginTransaction();  
    $query = 'INSERT INTO likes (user_id, article_id)  
          VALUES (:user_id, :article_id)';                 // Query
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->bindValue(':user_id', $user_id);  // Bind value from query string
    $statement->bindValue(':article_id', $article_id);  // Bind value from query string
    $statement->execute();
    $query='UPDATE article SET like_count = like_count + 1
        WHERE id = :article_id';
    $statement = $GLOBALS['connection']->prepare($query);   
    $statement->bindValue(':article_id', $article_id);  // Bind value from query string   
    $statement->execute();
    $GLOBALS['connection']->commit(); 
                                    // Commit transaction
    return TRUE;
  } catch (PDOException $error) {                                // Failed to update
    echo 'We were not able to update the article ' .$article_id . ' for user '. $user_id. ' ' . $error->getMessage();       
    $GLOBALS['connection']->rollback();                                    // Roll back all SQL
    return FALSE;
  }
}

function remove_like_by_id($user_id, $article_id) {
  try {
    $GLOBALS['connection']->beginTransaction();  
    $query = 'DELETE FROM likes WHERE user_id= :user_id 
          AND article_id= :article_id';               
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->bindValue(':user_id', $user_id);  
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
    $query='UPDATE article SET like_count = like_count - 1
        WHERE id = :article_id';
    $statement = $GLOBALS['connection']->prepare($query);   
    $statement->bindValue(':article_id', $article_id);  
    $statement->execute();
     echo 'We were  able to update the article ' ; 
    $GLOBALS['connection']->commit();     
    return TRUE;
  } catch (PDOException $error) {                               
    echo 'We were not able to update the article ' .$article_id . ' for user '. $user_id. ' ' . $error->getMessage();       
    $GLOBALS['connection']->rollback();         
    return FALSE;
  }
}

/* Comments functions */

function get_comments_by_id($id) {
  $query="SELECT  user.*, comments.* FROM comments 
          JOIN user ON comments.user_id = user.id   
          WHERE article_id = :id 
          ORDER BY comments.id ASC";  
  $statement = $GLOBALS['connection']->prepare($query);
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

function get_category_by_id($id) {
	$connection = $GLOBALS['connection'];
	$query = 'SELECT * FROM category WHERE id=:id';     // Query
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Category');     // Object   --- do this because of constructor having defaults (see https://www.electrictoolbox.com/php-pdo-fetch-class-gotcha/)
		$Category = $statement->fetch();                // Fetch
	}
	if ($Category) {
		return $Category;
	} else {
	  return FALSE;
  }
}

function get_comments_reply_form_short($name, $article_id, $toplevelparentid=0, $nesting_level=0,  $replyto=0) {    
  $form = '<form id="form-comment" class="bold" method="post" style="display:none;"/action="/phpsqlbook/cms/add_comment?article_id=' . $article_id  .  '" >';
  $form .= '<span id="reply_first" class="down">' . $name . '  <span id="reply_name"></span></span>';
  $form .= '<label for="comment" style="padding-left:0px">Comment:</label>';
  $form .= ' <textarea id="comment" name="comment"></textarea><br/>';
  $form .= '  <button type="submit" >Submit Comment</button>';
  $form .= ' </form>';
   $form .= ' <script>';
  $form .= '  $(".link-form").each(function() { ';
  $form .= '   $(this).click(function() { ';
  $form .= '   var act = "/phpsqlbook/cms/add_comment?article_id=' . $article_id  . '";';
    $form .= '   if (! $("#form-comment").is(":visible")) {   ';

  $form .= '    $("#form-comment").toggle(); } ';
  $form .= ' });   }); </script>';
  return $form;
}

function get_comment_total($id) {
    $connection = $GLOBALS['connection'];
    $query = 'SELECT article.* 
              FROM article  
      WHERE article.id=:id';      
    $statement = $connection->prepare($query);        
    $statement->bindValue(':id', $id);   
    if ($statement->execute() ) {
        $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'ArticleSummary');     // Object
        $Article = $statement->fetch();
    }
    if ($Article) {
        return $Article->comment_count;
    } else {
        return FALSE;
    }
}

function get_comments_list($id) {
  $list = new CommentList(get_comments_by_id($id));
  $table = '<div class="down"><ol class="commenterbox comment-box">';
  foreach ($list->comments as $comment) {
    $table .=  '<ol class="border-box"><ol class="children comment-box">';
    $table .=  '<li class="comment_reply">';
    if (!isset( $comment->image) ) {
       $comment->image = "blank.png";
    }
    $table .=  '<img class="thumb" src="../../uploads/' . $comment->image . '"/>';
    $table .=  '</li>'; 
    $table .=  '<li class="small_name">'; 
    $table .=  '<span class="comment_name">' . $comment->forename . ' ' . $comment->surname . '</span>';
    $table .=  '<hr><i>' . date("F jS Y g:i a", strtotime($comment->posted)) . '</i>';
    $table .=  '<li class="comment_reply_below">' . $comment->comment . '</li></ol>';
  }
  $table .= "</ol></ol></div>"; 
  if (isset($_SESSION['user_id'])) { 
    $table .=  '<a class="bold link-form" id="link0" href="#">Add a comment</a>';
    $table .= get_comments_reply_form_short($_SESSION['name'] , $id);
  }
  return $table;
}

/* Nested comments */

function get_comments_array( $article_id) {
  $commentslist = new CommentList(get_comments_by_id($article_id));
  var_dump($commentslist);
  $comments_table = '<div class="down"><ol class="commenterbox comment-box">';
  $commentslist2 = array();
  $commentslist2 = sort_comments_array($commentslist, $commentslist2);
  foreach ($commentslist2 as $comment) {
    $comments_table .= '<ol class="border-box"><ol class="children comment-box ';
    $previous = '';
    if (!isset( $comment->image) ) {
       $comment->image = "blank.png";
    }
    if (($comment->repliedto_id)!=0) {
      $commenter = get_previous_commenter_by_name($comment->repliedto_id);
      $previous = $commenter->forename . ' ' . $commenter->surname;
    }
    if ($comment->nestinglevel>0) {
      $depth = $comment->nestinglevel;
      if ($depth>2) { 
        $depth=2;  
      }
      $comments_table .= ' depth-' . $depth;
    }   
    $comments_table .=  '">';
    $comments_table .= '<li class="comment_reply"><img class="thumb" src="../../uploads/' . $comment->image . '"/></li>'; 
    $comments_table .= '<li class="small_name"><a class="comment_name" href="/phpsqlbook/cms/profile?id=' . $comment->user_id . '">' .  $comment->forename . ' ' . $comment->surname . '</a>';
    if ($comment->nestinglevel>0) {
      $comments_table .=  '        < In reply to: ' . $previous; 
    }
    $comments_table .=  '<hr><i>' . time_elapsed_string(date("F jS Y g:i a", strtotime($comment->posted))) . '</i>';
    if (isset($_SESSION["user_id"])) {
      $comments_table .=  '<a data-id="' .  $comment->forename . ' ' . $comment->surname .'" class="bold link-form" id="link' . $comment->id . '" href="#">Reply</a>';
    }
    $comments_table .=  '<li class="comment_reply_below">' . $comment->comment . '</li><li id="comlink'. $comment->id . '"></li></ol>';
  }
  $comments_table .= "</ol></ol></div>";   
  if ( isset($_SESSION['user_id'])) { 
    $comments_table .=  '<a class="bold link-form" id="link0" href="#">Add a comment</a><span id="comlink0"></span>';
    if (isset($comment)) {
        $comments_table .= get_comments_reply_form( $_SESSION['name'] , $article_id, $comment->toplevelparent_id, $comment->nestinglevel, $comment->repliedto_id);
    } else {
      $comments_table .= get_comments_reply_form($_SESSION['name'] , $article_id);
    }
  }
  return $comments_table;
}

function get_comments_reply_form($name, $article_id, $toplevelparentid=0, $nesting_level=0,  $replyto=0) {    
  $form = '<form id="form-comment" class="bold" method="post" style="display:none;"/action="/phpsqlbook/cms/add_comment?article_id=' . $article_id . '&nesting_level='. $nesting_level  . '&toplevelparentid='. $toplevelparentid  . '&replyto=' .  '" >';
  $form .= '<span id="reply_first" class="down">' . $name . '  <span id="reply_name"></span></span>';
  $form .= '<label for="comment" style="padding-left:0px">Comment:</label>';
  $form .= ' <textarea id="comment" name="comment"></textarea><br/>';
  $form .= '  <button type="submit" >Submit Comment</button>';
  $form .= ' </form>';
  $form .= ' <script>';
  $form .= '  $(".link-form").each(function() { ';
  $form .= '   $(this).click(function() { ';
  $form .= '   var act = "/phpsqlbook/cms/add_comment?article_id=' . $article_id . '&nesting_level='. $nesting_level . '&toplevelparentid='. $toplevelparentid  . '&replyto=' . '";';
  $form .= '   if (! $("#form-comment").is(":visible")) {   ';
  $form .= '    if( $("a:focus").attr("data-id")!=null ) { ';
  $form .= '    $("#reply_name").html(" replying to: " + $("a:focus").attr("data-id")); } ';
  $form .= '    $("#form-comment").attr("action", act + event.target.id );  ';
  $form .= '    if ( event.target.id == "link0" ) { ';
  $form .= '    $("#reply_name").html("" ); }  ';
  $form .= '    $("#form-comment").appendTo("#com" + event.target.id); } ';
  $form .= '    $("#form-comment").toggle(); ';
  $form .= ' });   }); </script>';
  return $form;
}

function get_previous_commenter_by_name($id) {
	$connection = $GLOBALS['connection'];
	$query = 'SELECT user.id, user.forename, user.surname FROM comments
            JOIN user ON comments.user_id = user.id   
              WHERE comments.id=:id';             // Query
	$statement = $connection->prepare($query);              // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);      // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); // Object
		$User = $statement->fetch();                        // Fetch
	}
	if ($User) {
		return $User;
	} else {
	    return FALSE;
    }
}

function sort_comments_array($commentslist, $commentslist2) {
 foreach ($commentslist->comments as $comment1) {
    $comment1->nestinglevel = 0;
    if ($comment1->repliedto_id > 0) {
      $comment1->nestinglevel = 1;
    }
   if ($comment1->toplevelparent_id == 0) {
    array_push($commentslist2, $comment1);
   }
   array_reverse($commentslist->comments);
   foreach ($commentslist->comments as $comment2) {
     if ($comment2->toplevelparent_id == $comment1->id) {
       array_push($commentslist2, $comment2);
     }
    }
  }
  return $commentslist2;
}



/* Display template sections functions */

function get_HTML_template($template,$object=""){
   

    
          include("includes/".$template.".php");    
         
}

function get_menu() {
    $categorylist = new CategoryList(get_category_list());
    $list = '';
    foreach($categorylist->categories as $category) {
        $list .= '<a href="'.$GLOBALS['root'] .$category->name.'">'.$category->name.'</a>';
    }
    return $list;
}

function get_category_list() {
  $query = 'SELECT * FROM category'; // Query
  $statement = $GLOBALS["connection"]->prepare($query); 
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

  $result  = '<div class="paginator">';
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        $result .= $i . '&nbsp;';
      } else {
        $result .= '<u><a href="?show=' . $show;
         if (isset($search)) {
         $result .= '&term='.$search; 
        }
        $result .= '&from=' . (($i-1) * $show) . '">' . ($i) . '</a></u>&nbsp;';
       }
    }
  }
  echo "<br/>" . $result . '</div>';
}

/* Miscellaneous functions // Third party functions */

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

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

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

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>