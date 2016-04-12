<?php 
function get_general_mime_type($filetype){
  $media_array = explode('/', $filetype);           // Split $filetype into array at /
  $filetype    = $media_array[0];                   // Get the first key
  return $filetype; 
}

function display_media($media){
  $filetype = get_general_mime_type($media->type);  // Get the general type fo file
  switch ($filetype) {                              // switch based on general type
    case 'image':                                   // If image generate <img>
      $displayHTML = '<img src="' . $media->thumb . '" alt="' . $media->alt . '">';
      break;
    case 'audio':                                   // If audiogenerate <audio>
      $displayHTML = '<audio controls><source src="' . $media->filepath . '"></audio>';
      break;
    case 'video':                                   // If video generate <video>
      $displayHTML = '<video controls><source src="' . $media->filepath . '"></video>';
      break;
    default:                                        // Else link to file + show type
      $displayHTML = '<a href="' . $media->filepath . '">' . $media->name . '
           ' . $media->filetype . '()</a>';
      break;
  }
  return $displayHTML;                              // Return code to show the file
}

foreach ($files as $file) {                           // Loop through media ?>
  <div class="col-md-3" id="thumbnails">
    <div class="panel panel-default">
      <div class="panel-heading"><?=$file->title?></div>
      <div class="panel-body"><?= display_media($file); ?></div>
    </div>
  </div>
<?php } ?>