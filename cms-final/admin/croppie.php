
<?php 
include '../config.php';
include 'includes/headercopy.php';
 ?>

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
<?php include 'includes/footer.php'; ?>