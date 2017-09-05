<?php 

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
$GLOBALS['connection'] = new PDO("mysql:host=127.0.0.1;dbname=cms", 'root', '');
$GLOBALS['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

class Gallery {
 public $id;
 public $name;
 public $mode;
 public $items;
 public $firstImage;

 function __construct($id = '', $name = NULL, $mode = NULL, $items = NULL) {
  $this->id    = ( isset($id)    ? $id    : '');
  $this->name  = ( isset($name)  ? $name  : '');
  $this->mode  = ( isset($mode)  ? $mode  : '');
  if ($this->id !='') {
   $this->getGalleryContent();
   $this->getFirstImageFromGallery();
  }
 }

 function create() {
  $connection = $GLOBALS['connection'];                              // Connection
  $sql = 'INSERT INTO gallery (name, mode) 
          VALUES (:name, :mode)'; // SQL
  $statement = $connection->prepare($sql);                   // Prepare
  $statement->bindValue(':name',        $this->name);        // Bind value
  $statement->bindValue(':mode', $this->mode); // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
        $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
  }
  return $result;                                                   // Success / fail
 }

 function update() {
  $connection = $GLOBALS['connection'];                             // Connection
  $sql = 'UPDATE gallery SET name = :name, mode = :mode WHERE id = :id'; //SQL
  $statement = $connection->prepare($sql);                          // Prepare
  $statement->bindValue(':id',          $this->id);                 // Bind value
  $statement->bindValue(':name',        $this->name);               // Bind value
  $statement->bindValue(':mode', $this->mode);        // Bind value
  try {
   $statement->execute();
   $result = TRUE;
  } catch (PDOException $error) {                                    // Otherwise
       $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
  }
  return $result;                                                   // Say succeeded
 }

 function delete() {
  $connection = $GLOBALS['connection'];                              // Connection
  $sql = 'DELETE FROM gallery WHERE id = :id';                      // SQL
  $statement = $connection->prepare($sql);                           // Prepare
  $statement->bindValue(':id', $this->id, PDO::PARAM_INT);           // Bind ID
   try {
  $statement->execute();                                        // If executes
   $result = TRUE;                                                   // Say succeeded
  } catch (PDOException $error) {                                                            // Otherwise
       $result = $error->errorInfo[1] . ': ' . $error->errorInfo[2];  // Error
  }  
  return $result;
 }

 function getGalleryContent() {
   $query = 'SELECT * FROM galleryitems WHERE gallery_id = :gallery_id ORDER BY priority'; // Query
   $statement = $GLOBALS['connection']->prepare($query);    // Prepare
   $statement->bindParam(":gallery_id", $this->id);         // Bind
   $statement->execute();                                   // Execute
   $statement->setFetchMode(PDO::FETCH_OBJ);                // Step 4 Set fetch mode to object
   $galleryitems = $statement->fetchAll();                  // Get data
   $this->items = $galleryitems;  
 }

 function getFirstImageFromGallery() {
     $this->firstImage = 'read';
  $connection = $GLOBALS['connection'];       // Connection
  $query = 'SELECT media.*
            FROM galleryitems INNER JOIN media
            ON galleryitems.media_id = media.id
            WHERE galleryitems.gallery_id = :id
            LIMIT 1';           // Query
    $statement = $connection->prepare($query); 
    $statement->bindValue(':id', $this->id, PDO::PARAM_INT);   // Bind value from query string
  if ($statement->execute() ) {
      $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Media');     // Object
      $Media = $statement->fetch();
  }
  if ($Media) {
      $this->firstImage = 'yes';
      echo "yes";
    } else {
      $this->firstImage = 'nowt';
        echo "no";
    }
 }
}

$gallery = new Gallery(1);

?>
