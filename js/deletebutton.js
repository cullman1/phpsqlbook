            $(".deleter").click(function(){
            
            var id = $(this).attr('name').replace("deletebutton","");
            $('#media_id').val(id);
               var formData = new FormData($('form')[2]); 
            var r = confirm("Are you sure you want to delete this item " + id);
            if (r == true) 
            {
 $.ajax({
        url: 'delete-item.php?media_id='+id,  //Server script to process data
        type: 'GET',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            return myXhr;
        },
        //Ajax events
        success: function(data, status) {
          
            $('#replacebody').html(data);
            $("#Status_Post").html(" <br/><span class='red' style='color:red;'>Item successfully deleted!</span>");
        
        },
        error: function(xhr, desc, err) {
          console.log(xhr);
          alert("Details: " + desc + "\nError:" + err);
        },
          // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });   
  }
});

