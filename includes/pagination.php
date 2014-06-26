<?php if (($recordsVisible>0) && ($recordsVisible>$recordsPerPage))
{  ?>

<ul class="pagination">
        <?php 
         $currentPage = 1;
         $fileName = basename($_SERVER['PHP_SELF']);
         $fileName = str_replace(".php","", $fileName);
         //Temp fix
         if ($fileName=="mainsite") {$fileName="../pages/mainsite";}
         if (isset($_REQUEST["page"]))
         {       
            $currentPage = $_REQUEST["page"];
         }
         if ($currentPage == 1)
          { ?>
            <li class="disabled"><a href="#">&laquo;</a></li>
       <?php } 
        else 
          {
        ?>
            <li><a href="<?php echo $fileName; ?>.php?page=<?php echo ($currentPage-1)?>">&laquo;</a></li>
          <?php
          }
          $pageNo = 1;
          $records = $totalRecords-1;
          if ($records<=2)
          {
            $records=3;
          }
          
          for ($i=1;$i<$records+2;$i=$i+$recordsPerPage)
          { ?>
            <li><a href="<?php echo $fileName; ?>.php?page=<?php echo $pageNo?>"><?php echo $pageNo?></a></li>
            <?php    $pageNo++;
          } 
          if ($currentPage == ($pageNo-1))
          { ?>
            <li class="disabled"><a href="#">&raquo;</a></li>
    <?php } 
          else 
          { ?>
            <li><a href="<?php echo $fileName; ?>.php?page=<?php echo ($currentPage+1)?>">&raquo;</a></li>
    <?php } ?>
</ul>
<?php } ?>