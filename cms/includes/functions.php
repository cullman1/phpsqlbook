<?php
function field_replace($body, $matches, $row) {
  foreach($matches as $value) {         
    $replace = str_replace("{{","", $value);
    $replace = str_replace("}}","", $replace);
    $body =str_replace($value,$row->{$replace},$body);
  } 
  return $body; 
}

function hyphenate_url($article_list) {
  foreach ($article_list as $article) {
    $article->{"article.title_url"} = str_replace(' ','-',  $article->title);
  }
  return $article_list;
}

function get_articles_by_category( $show, $from, $sort='', $dir='ASC',$category=0, $name='',$category_name) {
  $query= "SELECT article.*, category.* FROM article JOIN 
           user ON user.id = user_id JOIN category ON 
       category.id= category_id WHERE published <= now()";
  //If category id not 0 and name present, 
  //add a clause with id and name to the SQL
  if (($category > 0) && (!empty($name))) {
    $query .= ' AND  title=:name';
  } 
  //Else if only category id not 0, only add id clause
  else if ($category > 0) {
    $query .= ' AND category_id = :id';
  }
  //If sort not add a sort clause
  if (!empty($sort)) {
    $query .= " Order By " . $show . " " . $dir;
  }

  if (!empty($category_name)) {
      $query .= " AND category.name = :id";
      $category = $category_name;
   
  }
  //Get limited page of articles
  if (!empty($show)) {
    $query .= " limit " . $show . " offset " . $from;
  }
  $statement = $GLOBALS['connection']->prepare($query);
  //Get limited page of articles
  if (($category > 0) && (!empty($name))) {
     $statement->bindParam(":name", $name); 
     $statement->bindParam(":id", $category); 
  }  else if (($category > 0) || (!empty($category_name))) {
     $statement->bindParam(":id", $category);    
  }
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $article_list = $statement->fetchAll();  
  return hyphenate_url($article_list);
}


function get_article_by_seo_title($seo_title) {
    // This had conflicts for the id colum in article and user
    $connection = $GLOBALS['connection'];
    $query = 'SELECT article.*, category.name, user.id AS user_id, user.forename, user.surname, user.email, user.image, 
      media.filepath, media.filename, media.alt, media.mediatype, media.thumb 
      FROM article 
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

function getHTMLTemplate($template,$object=""){
    switch($template) {
        
        default:
            include("/templates/".$template.".php");     

            break;
    }
}

function getMenu() {
    $categorylist = new CategoryList(getCategoryList());

    $list = '';
    foreach($categorylist->categories as $category) {
        $list .= '<a href="'.$GLOBALS['root'] .$category->name.'">'.$category->name.'</a>';
    }
    return $list;
}

function get_articles_by_search($show='', $from='',
$sort='', $dir='ASC', $search='', $user='0') {
  $query= "SELECT article.*, category.* FROM article JOIN
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
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $article_list = $statement->fetchAll();  
  $article_list = hyphenate_url($article_list);
  //If search not empty, highlight search term
  if (!empty($search) && !empty($show)) { 
    foreach($article_list as $article) {
      $article->content =str_ireplace($search,
      "<b class='yellow'>".$search."</b>", 
      $article->content); 
    }
  }
  return $article_list;
}

function check_user() {
 if (!isset($_SESSION['user_id'])) { 
  return "0";
 }
 return $_SESSION['user_id'];
}

// Get categories
function getCategoryList() {

  $query = 'SELECT * FROM category'; // Query
  $statement = $GLOBALS["connection"]->prepare($query); 
  $statement->execute(); 
   $statement->setFetchMode(PDO::FETCH_OBJ);      // Step 4 Set fetch mode to array
  $category_list = $statement->fetchAll();      // Step 4 Get all rows ready to display

  return $category_list;
}

function create_slug($title) {
    var_dump($title);
    $title = strtolower($title);
    $title = trim($title);
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
}

function create_pagination($count, $show, $from, $search) {
  $total_pages  = ceil($count / $show);   // Total matches
  $current_page = ceil($from / $show) + 1;    // Current page

  $result  = '';
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        $result .= $i . '&nbsp;';
      } else {
        $result .= '<u><a href="?show=' . $show;
         if (isset($search)) {
         $result .= '&search='.$search; 
        }
        $result .= '&from=' . (($i-1) * $show) . '">' . ($i) . '</a></u>&nbsp;';
       }
    }
  }
  echo "<br/>" . $result;
}
?>