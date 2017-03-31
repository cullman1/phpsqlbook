<?php

$best_sellers = array(
'Beet', 'Broccoli', 'Carrot', 'Corn', 'Kale',
'Lettuce', 'Onion', 'Parsnip', 'Potato', 'Squash',
'Tomato', 'Zucchini');
?>
<!DOCTYPE html>
<html>
<head> ... </head>
<body>
<h1>Best Sellers</h1>
<ul>
<li><?php echo $best_sellers[0]; ?></li>
<li><?php echo $best_sellers[1]; ?></li>
<li><?php echo $best_sellers[2]; ?></li>
</ul>
<p>
(Total items: <?php echo count($best_sellers); ?>)
</p>
</body>
</html>