<?php 
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$tsql = "select category_name, category_template, category.category_id, count(*)  as items FROM 387732_phpbook1.category JOIN 387732_phpbook1.article ON article.category_id = category.category_id group by category_name having count(*) > 0";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

?>
<?php include '../includes/header.php' ?>

      <a class="btn btn-default" href="new-category.php" role="button">New Category</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Items</th>
                <th>Category Template</th>
                      <th>Edit Category</th>
          </tr>
        </thead>
        <tbody>
           <?php while($row = mysql_fetch_array($stmt)) { ?>
          <tr>
            <td><a href="category-view.php?categoryid=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a></td>
            <td><?php echo $row['items']; ?></td>
            <td><?php echo $row['category_template']; ?></td>
            <td><a href="edit-category.php?categoryid=<?php echo $row['category_id'];?>"><span class="glyphicon glyphicon-ok"></span></a></td>
          </tr>
             <?php } ?>
        </tbody>
      </table>


<?php include '../includes/footer.php' ?>