<?php

function clean($text) {
	$text = trim($text);
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', TRUE);
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

function get_category_by_name($name) {
	$connection = $GLOBALS['connection'];
    $query = 'SELECT name FROM category 
              WHERE LOWER(name) = LOWER(:name)';        // Query
	$statement = $connection->prepare($query); 
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':name', $name);              // Bind value
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Category');     // Object
		$Category = $statement->fetch();                // Fetch
	}
	if ($Category) {
		return $Category;
	} else {
	    return FALSE;
    }
}

function get_article_by_id($id) {
	$connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, user.*, 
      media.filepath, media.filename, media.alt, media.type 
      FROM article 
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.id=:id';                             // Query
	$statement = $connection->prepare($query);          // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
		$Article = $statement->fetch();
	}
	if ($Article) {
		return $Article;
	} else {
	    return FALSE;
    }
}

function get_article_by_title($title) {
	$connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, user.*, 
      media.filepath, media.filename, media.alt, media.type 
      FROM article 
      LEFT JOIN user ON article.user_id = user.id
      LEFT JOIN media ON article.media_id = media.id
      WHERE article.title=:title';                             // Query
	$statement = $connection->prepare($query); 
	$statement->bindValue(':title', $title);  // Bind value from query string
	if ($statement->execute() ) {
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article');     // Object
		$Article = $statement->fetch();
	}
	if ($Article) {
		return $Article;
	} else {
	    return FALSE;
    }
}

function get_user_by_id($id) {
	$connection = $GLOBALS['connection'];
	$query = 'SELECT * FROM user WHERE id=:id';             // Query
	$statement = $connection->prepare($query);              // Prepare
	$statement->bindValue(':id', $id, PDO::PARAM_INT);      // Bind value from query string
	if ($statement->execute() ) {
//		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); // Object
		$statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); // Object
		$User = $statement->fetch();                        // Fetch
	}
	if ($User) {
		return $User;
	} else {
	    return FALSE;
    }
}

function get_category_list() {
  $connection = $GLOBALS['connection'];
  $query = 'SELECT * FROM category'; // Query
  $statement = $connection->prepare($query); 
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);   // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();           // Step 4 Get all rows ready to display
  return $category_list;
}

function get_article_list($id) {
  $connection = $GLOBALS['connection'];
  $id_present = ( (is_numeric($id)) ? $id : FALSE);
  $query = 'SELECT * FROM article';
  if ($id_present) {
    $query .= ' WHERE id = :id';
  }
  $statement = $connection->prepare($query); 
  if ($id_present) {
	$statement->bindValue(':title', $title);  // Bind value from query string
  }
  $statement->execute(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $article_list = $statement->fetchAll();
  return $article_list;
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

function create_category_dropdown($id) {
  $category_list = get_category_list();
  $dropdown = '<select name="category_id" id="category_id">';
  foreach ($category_list as $category) { 
    $dropdown .= '<option value="' . $category->id . '"';
    if ($id === $category->id) {
    	$dropdown .= ' selected';
    }
    $dropdown .= '>' . $category->name . '</option>';
  }
  $dropdown .= '</select>';
  return $dropdown;
}

function create_user_dropdown($id) {
  $user_list = get_user_list();
  $dropdown = '<select name="user_id" id="user_id">';
  foreach ($user_list as $user) { 
    $dropdown .= '<option value="' . $user->id . '"';
    if ($id === $user->id) {
    	$dropdown .= ' selected';
    }
    $dropdown .= '>' . $user->forename . ' ' . $user->surname . '</option>';
  }
  $dropdown .= '</select>';
  return $dropdown;
}

function format_date($datetime) {
	$date = date_create_from_format('Y-m-d H:i:s', $datetime);
    return $date->format('F d Y');
}

