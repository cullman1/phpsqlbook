</head>
<body>
  <header>
    <h1>the green room</h1>
    <nav>
      <a href="index.php">Home</a>
      <?php foreach ($category_list as $category) { ?>
        <a href="category.php?category_id=<?=$category['id']?>"
          <?php  if ($current_category == $category['id']) {
            echo 'class="selected"';
        } ?>
        	><?=$category['name'];?></a> 
      <?php } ?>
      <a href="article.php?article_id=">About</a>
      <a href="article.php?article_id=">Contact</a>
    </nav>
  </header>