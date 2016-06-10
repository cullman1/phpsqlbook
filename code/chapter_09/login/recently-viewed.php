<div class="tk-proxima-nova" style="float:right;">
    <h3 class="tk-proxima-nova">Recently Viewed</h3>
    <br/>
    <?php if (isset($_SESSION["viewed"])) { 
             foreach($_SESSION["viewed"] as $viewed)  {
                echo $viewed["url"] . " - " .  $viewed["title"] . "<br/>";
            }
          } else {
            echo "None";
          } ?>
</div>