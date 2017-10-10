<h2>Stock Activity</h2>
<?php
  $stock_level = 3;
  echo '<p>' . $stock_level . ' packs in stock</p>'; 
  echo '<p>New stock added</p>'; 
  echo '<p>' . ++$stock_level . ' packs in stock </p>';
  echo '<p>Stock removed</p>'; 
  echo '<p>' . --$stock_level . ' packs in stock </p>';
  echo '<p>Stock to be added next week</p>';
  echo '<p>'. $stock_level++ . ' packs in stock this week </p>';
?>