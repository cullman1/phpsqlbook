<?php 

/* Db Details */
require_once('../includes/db_config.php');

//$article_id = $_REQUEST['article_id'];
$article_id = 6;

/* Query SQL Server for selecting article and associated media. */
$select_article_sql = "SELECT title, content, article_id, category_id, parent_id FROM article where article_id=". $article_id;
$select_article_result = $dbHost->prepare($select_article_sql);
$select_article_result->execute();
$select_article_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting category. */
$select_category_sql = "select category_id, category_name FROM category";
$select_category_result = $dbHost->prepare($select_category_sql);
$select_category_result->execute();
$select_category_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting parent. */
$select_parent_sql = "select parent_id, parent_name FROM parent";
$select_parent_result = $dbHost->prepare($select_parent_sql);
$select_parent_result->execute();
$select_parent_result->setFetchMode(PDO::FETCH_ASSOC);

?>
<div id="body">
  <form method="post" enctype="multipart/form-data">
    <?php while($select_article_row = $select_article_result->fetch()) { ?>

    Title: <input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php echo $select_article_row['title']; ?>"/><br>

    Category: <br>
    <?php while($select_category_row = $select_category_result->fetch()) { ?>
      <input type="radio" name="CategoryId" value="<?php  echo $select_category_row['category_id']; ?>" 
      <?php if( $select_category_row['category_id'] == $select_article_row['category_id']) { echo "checked";} ?> >
      <?php  echo $select_category_row['category_name']; ?><br>
    <?php } ?> 

<!-- Checkbox stylee
    Category: <br>
    <?php while($select_category_row = $select_category_result->fetch()) { ?>
      <input type="checkbox" name="CategoryId" value="<?php  echo $select_category_row['category_id']; ?>" 
      <?php if( $select_category_row['category_id'] == $select_article_row['category_id']) { echo "checked";} ?> >
      <?php  echo $select_category_row['category_name']; ?><br>
    <?php } ?> 
-->

<!--
    Category: 
    <select id="CategoryId" name="CategoryId">     
      <?php while($select_category_row = $select_category_result->fetch()) { ?>
        <option value="<?php  echo $select_category_row['category_id']; ?>"
            <?php if( $select_category_row['category_id'] == $select_article_row['category_id']) { echo "selected";} ?> >
            <?php  echo $select_category_row['category_name']; ?>
        </option>
      <?php } ?> 
    </select><br>
-->


    Parent:
    <select id="PageId" name="PageId">
      <?php while($select_parent_row = $select_parent_result->fetch()) { ?>
        <option value="<?php  echo $select_parent_row['parent_id']; ?>"
          <?php if( $select_parent_row['parent_id'] == $select_article_row['parent_id']) { echo "selected";} ?>>
          <?php  echo $select_parent_row['parent_name']; ?>
        </option>
      <?php } ?> 
    </select>

    <?php } ?>         
</div>
