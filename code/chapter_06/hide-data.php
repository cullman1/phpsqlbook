<?php require_once('../includes/db_config.php');
      $sel_articles_set = $dbHost->prepare("select article_id, title, content, category_name, category.category_id, full_name, user.user_id, date_posted, date_published, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id limit 10");
      $sel_articles_set->execute(); 
include '../includes/header.php' ?>
<table class="table table-hover">
   <tr>
      <th>Title</th>
      <th>Category</th>
      <th>Author</th>
      <th>Date Posted</th>
      <th>Delete</th>
   </tr>
   <?php while($sel_articles_row = $sel_articles_set->fetch()) {  ?>
   <tr>   
      <td><?php echo $sel_articles_row['title']; ?></td>
      <td><?php echo $sel_articles_row['category_name']; ?></td>
      <td><?php echo $sel_articles_row['full_name']; ?></td>
      <td><?php echo $sel_articles_row['date_published']; ?></td>  
      <td><a href="delete-data.php?article_id=<?php echo $sel_articles_row['article_id']; 
          if ($sel_articles_row['date_published']!=null) { echo "&publish=delete";} ?>">    
          <?php if ($sel_articles_row['date_published']==null) { ?> 
           <span class="glyphicon glyphicon-plus"></span> <?php } else { ?>             
           <span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
   </tr>
   <?php } ?>
</table>
<?php include '../includes/footer.php' ?>