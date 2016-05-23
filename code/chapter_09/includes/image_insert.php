<div class='modal modal-content modal-header fade'></div>
<a class="btn" title="Insert document" id="imgBtn"  tabindex="-1" ><i class="icon-picture"></i></a>
<script type="text/javascript">
$(function() {
  $("#imgBtn").on("click", document_click);
  function document_click() {
   var doc1 = document.getElementById("doc_upload");
   filepath = doc1.value;
   if (filepath != '') {
    var sections = filepath.split('\\');
    var file = sections[2];
    var el = document.getElementById("rich-text-container");
    var txt = el.innerHTML;
    txt = txt.replace(/"/g, '');
    if((el.innerHTML != 'undefined')) {
      el.innerHTML=  txt + " <a target='_blank'  
      href='../uploads/" + file + "'>" + file + "</a>" ;
    }
  }
 }
}); </script>