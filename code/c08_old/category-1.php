<?php
  require_once 'database-connection.php';                       // Database connection
  include 'classes/Category.php';                               // Category class
  include 'classes/ArticleSummary.php';                         // ArticleSummary class
  $category_id = ( isset($_GET['category_id']) ? $_GET['category_id'] : ''); 
  if (is_numeric($category_id)) {                               // If got a category id
    
    // Get the category information
    $sql = 'SELECT * FROM category WHERE category_id=:id';      // Query
    $statement = $pdo->prepare($sql);                           // Prepare
    $statement->bindValue(':id', $category_id, PDO::PARAM_INT); // Bind category id
    $statement->execute();                                      // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');     // Set fetch mode
    $category = $statement->fetch();                            // Store in variable
    
    // Get the articles in this category
    $sql = 'SELECT article.article_id, 
             article.title, 
             article.summary, 
             article.user_id, 
             article.category_id, 
             article.published,
             CONCAT(user.forename, " ", user.surname) AS author,
             category.name AS category,
             image.image_id as image_id, 
             image.file AS image_file, 
             image.alt AS image_alt
            FROM article
             LEFT JOIN user ON article.user_id = user.user_id 
             LEFT JOIN category ON article.category_id = category.category_id 
             LEFT JOIN articleimage ON articleimage.article_id = article.article_id
             LEFT JOIN image ON articleimage.image_id = image.image_id
            WHERE article.category_id=:id 
             AND article.published = TRUE
            ORDER BY article.article_id DESC';                    // Query
    $statement = $pdo->prepare($sql);                             // Prepare
    $statement->bindValue(':id', $category_id, PDO::PARAM_INT);   // Bind category id
    $statement->execute();                                        // Execute
    $statement->setFetchMode(PDO::FETCH_CLASS, 'ArticleSummary'); // Set fetch mode
    $article_list = $statement->fetchAll();                       // Store in variable
  }
  if (empty($category) || empty($article_list)) {                 // If objects empty
        header( "Location: page-not-found.php" );
        exit();                                                   // Redirect user
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?= $category->name ?></title>
    <meta name="description" value="<?= $category->description ?>">
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1><?= $category->name ?></h1>
    <?php if (!empty($article_list)) { ?>    
      <?php foreach ($article_list as $article) { ?>
        <div class="article">
          <img src="<?= $article->image_file ?>" alt="<?= $article->image_alt ?>">
     <a href="article.php?article_id=<?=$article->article_id?>"><?=$article->title?></a>
          <p><?=$article->summary?></p>
        </div>
      <?php } ?>
    <?php } else { echo "No articles were found in this category"; } ?>
  </body>
</html>