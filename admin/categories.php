<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting categories by group. */
$select_categoriesbygroup_sql = "select category_name, category_template, parent_category, category.category_id, count(article_id) as items FROM category Left outer JOIN article ON article.category_id = category.category_id  group by category_name "; 
$select_categoriesbygroup_result = $dbHost->prepare($select_categoriesbygroup_sql);
$select_categoriesbygroup_result->execute();
$select_categoriesbygroup_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
<a class="btn btn-default" href="new-category.php" role="button">New Category</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Items</th>
            <th>Category Template</th>
            <th>Parent Category</th>
            <th>Edit Category</th>
          </tr>
        </thead>
        <tbody>
           <?php while($select_categoriesbygroup_row = $select_categoriesbygroup_result->fetch()) { ?>
          <tr>
            <td><a href="category-view.php?categoryid=<?php echo $select_categoriesbygroup_row['category_id']; ?>"><?php echo $select_categoriesbygroup_row['category_name']; ?></a></td>
            <td><?php echo $select_categoriesbygroup_row['items']; ?></td>
            <td><?php echo $select_categoriesbygroup_row['category_template']; ?></td>
               <td><?php echo $select_categoriesbygroup_row['parent_category']; ?></td>
            <td><a href="edit-category.php?categoryid=<?php echo $select_categoriesbygroup_row['category_id'];?>"><span class="glyphicon glyphicon-ok"></span></a></td>
          </tr>
             <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>