<?php
class ArticleList {
  public $listName;			// String
  public $articles = array();			// Array holding child objects

  function __construct($listName, $article_list) {
    $this->listName = $listName;
    $count = 0;
    foreach($article_list as $row) {
      $article = new ArticleSummary($row->{"article.id"},  $row->{"article.title"},  $row->{"article.content"}, $row->{"article.published"}, $row->{"article.user_id"},$row->{"category.template"},$row->{"category.name"});
      $this->articles[$count] = $article;
      $count++;
    }
  }
}
?>
