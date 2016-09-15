
<a class="btn" title="Insert doc" id="docBtn" tabindex="-1" ><i class="icon-book"></i></a>
<script type="text/javascript">
$(function() {
  $("#docBtn").on("click", document_click);
  function document_click() {
   var doc1 = document.getElementById("doc_upload");
   filepath = doc1.value;
   alert(filepath);
   if (filepath != '') {
    var sections = filepath.split('\\');
    var file = sections[2];
    var el = document.getElementById("rich-text-container");
    var txt = el.innerHTML;
    txt = txt.replace(/"/g, '');
    if((el.innerHTML != 'undefined')) {
      el.innerHTML=txt + "<a target='_blank' href='../uploads/" +file+ "'>"+file+"</a>";
    }
  }
 }
}); </script>
