  <form id=form1 style="float:right;" class="navbar-form navbar-left" role="search"  method="post" onsubmit="assignurl();" action="\phpsqlbook\search\">
      <input id="search" name="search" type="text" />
    <input type="submit">
   </form>

<script type="text/Javascript">
    function assignurl() {
      var action = $('#search').val();
      $("#form1").attr("action", "/phpsqlbook/search/" + action+ "?from=10&show=10");
    }
</script>