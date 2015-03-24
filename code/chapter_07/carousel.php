<html>
    <head>
		<title>Image Carousel Example</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
    <body>
        <div style="width: 400px; padding: 50px;">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" >
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
     <img src="http://test1.phpandmysqlbook.com/code/images/chamomile.gif" alt="chamomile"/>
      <div class="carousel-caption">
          <h3>Chamomile - La Tranquilitte</h3>
      </div>
    </div>
<div class="item">
     <img src="http://test1.phpandmysqlbook.com/code/images/lavender.gif" alt="Lavender" />
      <div class="carousel-caption">
          <h3>Lavender - Aix-en-Provence</h3>
      </div>
    </div>
 <div class="item">
      <img src="http://test1.phpandmysqlbook.com/code/images/pansy.gif" alt="Pansy" />
      <div class="carousel-caption">
          <h3>Pansy - La delicate</h3>
      </div>
    </div>
  </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div> <!-- Carousel --></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

        </body>											</html>
