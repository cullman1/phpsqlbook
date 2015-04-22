<?php require_once('../includes/db_config.php');
$select_articles_sql = "select top 10 article_id, title, content, category_name, category.category_id, full_name, user.user_id, date_posted, date_published, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id";
$select_articles_result = $dbHost->prepare($select_articles_sql);
$select_articles_result->execute();
$select_articles_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Date Posted</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
             <?php while($select_articles_row = $select_articles_result->fetch()) {  ?>
          <tr>
            <td><?php echo $select_articles_row['title']; ?></td>
            <td><?php echo $select_articles_row['category_name']; ?></td>
            <td><?php echo $select_articles_row['full_name']; ?></td>
            <td><?php echo $select_articles_row['date_posted']; ?></td>  
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item <?php echo $select_articles_row['article_id'];?>&#39;);" id="delete1" href="delete-data.php?article_id=<?php echo $select_articles_row['article_id'];?>".><span class="glyphicon glyphicon-remove red"></span></a></td>
         </tr>
            <?php } ?>
        </tbody>
      </table>
<?php include '../includes/footer.php' ?>