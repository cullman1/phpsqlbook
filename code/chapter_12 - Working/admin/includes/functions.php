<?php
// Create objects
function init_article() {
  $article              = new stdClass();
  $article->id          = (filter_input(INPUT_GET, 'article_id',   FILTER_VALIDATE_INT) ? $_GET['article_id']   : 0); 
  $article->title       = ( isset($_POST['title'])   ? $_POST['title']   : '' );
  $article->content     = ( isset($_POST['content']) ? $_POST['content'] : '' );
  $article->published   = ( isset($_POST['published']) ? $_POST['published'] : '' ); 
  $article->category_id = (filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ? $_POST['category_id'] : 0);
  $article->user_id     = (filter_input(INPUT_POST, 'user_id',     FILTER_VALIDATE_INT) ? $_POST['user_id']     : 0);
  $article->media_id    = (filter_input(INPUT_POST, 'media_id',    FILTER_VALIDATE_INT) ? $_POST['media_id']    : 0);
  return $article;
}
function init_category() {
  $category           = new stdClass();
  $category->id       = (filter_input(INPUT_GET, 'category_id',   FILTER_VALIDATE_INT) ? $_GET['category_id']   : 0); 
  $category->name     = ( isset($_POST['name'])     ?   $_POST['name']         : '' );
  $category->template = ( isset($_POST['template']) ?   $_POST['template']     : '' );
  return $category;
}
function init_user() {
  $user             = new stdClass();
  $user->id         = (filter_input(INPUT_GET, 'user_id',  FILTER_VALIDATE_INT) ? $_GET['user_id']    : 0);
  $user->name       = ( isset($_POST['name'])     ?   $_POST['name']         : '' );
  $user->email      = (filter_input(INPUT_POST, 'email',  FILTER_VALIDATE_EMAIL) ? $_POST['email']    : '');
  $user->password   = ( isset($_POST['password'])     ?   $_POST['password']         : '' );
  $user->picture    = ( isset($_POST['profile'])     ?   $_POST['profile']         : '' );
  return $user;
}
function init_media() {
  $media           = new stdClass();
  $media->id       = (filter_input(INPUT_GET, 'media_id',  FILTER_VALIDATE_INT) ? $_GET['media_id']    : 0);
  $media->title    = ( isset($_POST['title'])    ?   $_POST['title']    : '' );
  $media->alt      = ( isset($_POST['alt'])      ?   $_POST['alt']      : '' );
  $media->type     = ( isset($_POST['type'])     ?   $_POST['type']     : '' );
  $media->filename = ( isset($_POST['filename']) ?   $_POST['filename'] : '' );
  $media->filepath = ( isset($_POST['filepath']) ?   $_POST['filepath'] : '' );
  $media->media_id = ( isset($_POST['thumb'])    ?   $_POST['thumb']    : '' );
  return $media;
}

// Media upload
function resize_image($path, $new_width, $new_height) {
  $file_type = exif_imagetype($path);                          // Get image type 
  list($current_width, $current_height) = getimagesize($path); // Get height and width of image 
  $ratio = $current_width / $current_height;                   // Get aspect ratio
  if ($new_width / $new_height > $ratio) {                     // If a portrait picture
    $new_width = $new_height * $ratio;                         // Set new width
  } else {                                                     // Otherwise is landscape / square
    $new_height = $new_width / $ratio;                         // Set new height
  }
  switch($file_type) {
    case 1:
      $thumbpath     = substr($path,0,-4)."_thumbnail.gif";           // Thumbnail path
      $current_image = imagecreatefromgif($path);                     // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagegif($new_image, $thumbpath);                               // Save image
      return $thumbpath;
    case 2:
      if (strtolower(substr($path,-4)) == '.jpg' ){                   // .jpg extension
        $thumbpath   = substr($path,0,-4)."_thumbnail.jpg";           // Thumbnail path
      } else {                                                        // Else .jpeg
        $thumbpath   = substr($path,0,-4)."_thumbnail.jpeg";          // Thumbnail path
      }
      $current_image = imagecreatefromjpeg($path);                    // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagejpeg($new_image, $thumbpath);                               // Save image
      return $thumbpath;
    case 3:
      $thumbpath     = substr($path,0,-4)."_thumbnail.png";           // Thumbnail path
      $current_image = imagecreatefrompng($path);                     // Current image
      $new_image     = imagecreatetruecolor($new_width, $new_height); // New blank image
      // Resample $current_image set to $new_image
      imagecopyresampled($new_image, $current_image, 0,0,0,0, $new_width, $new_height, $current_width, $current_height);
      imagepng($new_image, $thumbpath);                               // Save image
      return $thumbpath;
  }
  return '';
}

// Selectboxes
function get_category_selectbox($id) {
  $category_list = get_category_list_array(); 
  $selectbox = '<select name="category_id">';
  foreach ($category_list as $category) {
    $selectbox .= '  <option value="' . $category['id'] . '"';
    if ($category['id'] == $id) {
      $selectbox .= ' selected ';
    }
    $selectbox .= '>' . $category['name'] . '</option>';
  }
  $selectbox .= '</select>';
  return $selectbox;
}
function get_author_selectbox($id) {
  $author_list = get_user_list_array(); 
  $selectbox = '<select name="user_id">';
  foreach ($author_list as $author) {
    $selectbox .= '  <option value="' . $author['id'] . '"';
    if ($author['id'] == $id) {
      $selectbox .= ' selected ';
    }
    $selectbox .= '>' . $author['name'] . '</option>';
  }
  $selectbox .= '</select>';
  return $selectbox;
}

// Format date
function convert_date($date) {
  $date_object = new DateTime($date); // Create DateTime object
  $date_string = $date_object->format('d M Y (H:m:s a)'); // Format the DateTime object as string
  return $date_string;               // Return formatted string
}
?>