<div class="tk-proxima-nova" style="float:right;">
    <h3 class="tk-proxima-nova">Recently Viewed</h3>
    <br/>
    <?php if (isset($_SESSION["just_viewed"])) {
           $reverse = array_reverse($_SESSION["just_viewed"]);
             $i=1;
             foreach($reverse as $viewed)  {

                   echo "FILE: ".$viewed["title"]."<br>";
                if ($i!=1) {
                    echo $viewed["title"] . "<br/>";
                }
                $i++;
             }
            if ($i==2) {
                echo "None";
            } 
          } 
       ?>
</div>