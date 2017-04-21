<?php
  $now = time();
  echo 'Page created: ';
  echo date('l d M Y', $now) . '<br>';

  $offer_ends = 1767225599;
  $ends_array = getdate($offer_ends);
  echo '<b>Offer ends: </b> ';
  echo $ends_array['weekday'] . ' ';
  echo $ends_array['mday'] . ' ';
  echo $ends_array['month'] . ' ';
  echo $ends_array['year'];

?>
...
<div class="footer">&copy; <?php echo date("Y")?></div>