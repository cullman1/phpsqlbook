<?php
require_once('includes/check-user.php');                            // Is logged in
require_once('../includes/database-connection.php');                // DB connection
require_once('../includes/class-lib.php');                          // Classes
require_once('../includes/functions.php');                          // Classes

$name         = ( isset($_POST['name'])        ? $_POST['name']        : ''); // Get values
$description  = ( isset($_POST['description']) ? $_POST['description'] : ''); // Get values
$errors       = array('id' => '', 'name'=>'', 'description'=>'');             // Form errors
$alert        = '';                                                           // Status messages
$show_form    = TRUE;                                                         // Show / hide form

$Category = new Category('new', $name, $description);           // Create Category object

if (isset($_POST['create'])) {
  $Validate = new Validate();                                // Create Validation object
  $errors   = $Validate->isCategory($Category);              // Validate Category object
  
  if (strlen(implode($errors)) < 1) {                        // If data valid
    $result = $Category->create();                           // Add category to database
  } else {                                                   // Otherwise
    $alert = '<div class="alert alert-danger">Please correct form errors</div>'; // Error
  }

  if ( isset($result) && ($result === TRUE) ) {            // Tried to create and it worked
    print_r($Category);
    $alert = '<div class="alert alert-success">Category added: new id is ' . $Category->id . '</div>';
    $show_form = FALSE;
  }

  if (isset($result) && ($result !== TRUE) ) {             // Tried to create and it failed
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}

include('includes/admin-header.php'); 
?>

<h2>Add category</h2>

<?= $alert ?>

<?php if ($show_form == TRUE) { ?>

<form action="category-create-rich-text.php" id="form" method="POST">
  <div class="form-group">
    <label for="title">Name: </label>
    <input type="text" name="name" value="<?= $Category->name ?>"  class="form-control">
    <span class="errors"><?= $errors['name'] ?></span>
  </div>
  <div class="form-group">
    <label for="description">Description: </label>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
        <div class="btn-group">
          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a data-edit="fontSize 5" class="fs-Five">Huge</a></li>
            <li><a data-edit="fontSize 3" class="fs-Three">Normal</a></li>
            <li><a data-edit="fontSize 1" class="fs-One">Small</a></li>
          </ul>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="bold" title="Bold"><i class="fa fa-bold"></i></a>
          <a class="btn btn-default" data-edit="italic" title="Italic"><i class="fa fa-italic"></i></a>
          <a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
          <a class="btn btn-default" data-edit="underline" title="Underline"><i class="fa fa-underline"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
          <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
          <a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-outdent"></i></a>
          <a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="justifyleft" title="Align Left"><i class="fa fa-align-left"></i></a>
          <a class="btn btn-default" data-edit="justifycenter" title="Center"><i class="fa fa-align-center"></i></a>
          <a class="btn btn-default" data-edit="justifyright" title="Align Right"><i class="fa fa-align-right"></i></a>
          <a class="btn btn-default" data-edit="justifyfull" title="Justify"><i class="fa fa-align-justify"></i></a>
        </div>
        <div class="btn-group">
          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
          <div class="dropdown-menu input-append">
            <input placeholder="URL" type="text" data-edit="createLink" />
            <button class="btn" type="button">Add</button>
          </div>
        </div>
        <div class="btn-group">
          <a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
        </div>
    </div>
    <div id="editor" style="overflow:scroll; height: 100px; border: 1px solid #333"><?= $Category->description ?></div>
    <input type="hidden" id="description" name="description" />
    <span class="errors"><?= $errors['description'] ?></span>
  </div>
  <input type="submit" value="save" name="create" class="btn btn-default"  />
</form>
<?php
 } else {
    include('includes/list-categories.php');
  } 
  include('includes/admin-footer.php');
?>
<script>
  $(function() {
    $('#editor').wysiwyg();
    $('#form').submit(function(event) {
      $('#description').val($('#editor').html());
    });
  });
</script>