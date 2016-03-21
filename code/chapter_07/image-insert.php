<div id="image3" class='modal modal-content modal-header fade' style="width:623px; overflow-x:hidden; overflow-y:hidden;height:675px;">
  
</div>
 <a class="btn" title="Insert image" id="pictureBtn"  tabindex="-1" ><i class="icon-book"></i></a>
<script type="text/javascript">
  $(function() {
  //Assign event handlers
  $("#pictureBtn").on("click", document_click);

  function document_click() {
  var doc1 = document.getElementById("document_upload");
  buttonname = doc1.value;
  
  if (buttonname != '')
  {
  var button1 = buttonname.split('\\');
  var buttonname1 = button1[2];


  var elem1 = document.getElementById("rich-text-container");
  var decoded = elem1.innerHTML;

  var new1 = decoded.replace(/"/g, '');
  if((elem1.innerHTML != 'undefined'))
  {

  elem1.innerHTML=  new1 + " <img src='../uploads/" + buttonname1 + "' />" ;
 
  }
  }

  }
  });
</script>