  <?php 
   ini_set('display_errors', '1');
   error_reporting(E_ALL);

   function calculate ( int $id) {
     $id = $id + 2;
     return $id;
   }

   $non_int = 'hello';
   echo calculate($non_int);
 ?>
