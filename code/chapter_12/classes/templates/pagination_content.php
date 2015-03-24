<div id="article">
    <h3><?php echo $get_article['title']; ?></h3>
    <p><i><?php echo date("F j, Y, g:i a", strtotime($get_article['date_posted'])); ?></i></p>
    <p><?php echo substr($get_article['content'], 0, 100); ?>...</p>
  </div>
  <?php 
  }
if ($total > $count) { ?>
<div class="pagination">
  for( $i = 0; $i < $total_pages; $i++ ) { // Pagination links
    if ( $page == $i ) {
      echo $i+1 . ' ';
    } else {
      ?><a href="pagination.php?search=<?php echo $trimmed_search; ?>&page=
        <?php echo $i; ?>"><?php echo $i+1; ?></a> <?php 
    }
  } ?>
  </div>
<?php } ?>
