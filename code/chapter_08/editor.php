 <div class="btn-toolbar" data-role="editor-toolbar" data-target="#rich-text-container">
  <div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size">
      <i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
      <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
      <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
    </ul>
   <a class="btn" data-edit="bold" title="Bold"><i class="icon-bold"></i></a>
   <a class="btn" data-edit="italic" title="Italic"><i class="icon-italic"></i></a>
   <a class="btn" data-edit="insertunorderedlist" title="Bullet list">
      <i class="icon-list-ul"></i></a>
    <a class="btn" data-edit="insertorderedlist" title="Number list">
      <i class="icon-list-ol"></i></a>
   <a class="btn" data-edit="justifyleft" title="Align Left">
      <i class="icon-align-left"></i></a>
   <a class="btn" data-edit="justifycenter" title="Center">
      <i class="icon-align-center"></i></a>
   <a class="btn" data-edit="justifyright" title="Align Right">
     <i class="icon-align-right"></i></a>
   <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink">
      <i class="icon-link"></i></a>
     </div>
       <div class="btn-group">
   <div class="dropdown-menu input-append">
      <input placeholder="URL" type="text" data-edit="createLink" />
      <button class="btn" type="button">Add</button>
    </div>
  <a class="btn" data-edit="html"><i class="icon-file-alt"></i></a>
  <a class="btn" data-edit="html"><i class="icon-file-alt"></i></a>
 <?php include '../includes/featured-image-modal.php' ?>
</div>
  </div>
</div>
<div id="rich-text-container">
  <?php if (isset($_POST["content"])) {
    if (!is_null($_POST["content"])){ 
      echo $_POST["content"]; 
    } else if (isset($row["content"])) {
      echo $row["content"];     
    }
  } ?>
</div>