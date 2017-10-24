<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../cms-final/lib/croppie/croppie.css" />
        <script src="../cms-final/lib/croppie/croppie.js"></script>
  </head>
  <body>

<style>
#page {
  background: #FFF;
  padding: 20px;
  margin: 20px;
}

#demo-basic {
  width: 200px;
  height: 300px;
}
</style>
<section>
<div id="page">
  <div id="demo-basic">
  </div>
</div>
</section>
<script>
$(function() {
  var basic = $('#demo-basic').croppie({
    viewport: {
      width: 150,
      height: 200
    }
  });
  basic.croppie('bind', {
    url: 'https://i.imgur.com/xD9rzSt.jpg',
    points: [77, 469, 280, 739]
  });
});
</script>
</body>
</html>