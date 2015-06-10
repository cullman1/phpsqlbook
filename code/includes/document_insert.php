<div class='modal modal-content modal-header fade'></div>
<a class="btn" title="Insert document" id="docBtn"  tabindex="-1" ><i class="icon-book"></i></a>
<script type="text/javascript">
$(function() {
  $("#docBtn").on("click", document_click);
  function document_click() {
   var doc1 = document.getElementById("doc_upload");
   buttonname = doc1.value;
   if (buttonname != '') {
    var abridged = buttonname.split('\\');
    var button1 = abridged[2];
    var el = document.getElementById("rich-text-container");
    var decoded = el.innerHTML;
    decoded = decoded.replace(/"/g, '');
    if((el.innerHTML != 'undefined')) {
      el.innerHTML=  decoded + " <a target='_blank' href='../uploads/" + button1 + "'>" + button1 + "</a>" ;
    } 
  }
 }
}); 

</script>
