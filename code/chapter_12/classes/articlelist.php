<?php
class ArticleList {
  public $listName;			// String
  public $articles = array();			// Array holding child objects

  function __construct($database, $listName, $article_list) {
    $this->listName = $listName;
    $this->database = $database;
    $count = 0;
    foreach($article_list as $row) {
      $article = new ArticleSummary($database,  $row->{"article.id"},  $row->{"article.title"},  $row->{"article.content"}, $row->{"article.published"}, $row->{"article.user_id"},$row->{"category.template"},$row->{"category.name"});
      $this->articles[$count] = $article;
      $count++;
    }
  }
}
?>
