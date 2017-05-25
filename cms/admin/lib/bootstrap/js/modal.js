(function(){
  // Create event handlers before detaching modal
  $('#gallery .image').on('click', function() {
    var image_id = $('input[name=featured]:checked').val();
    var image_path = $('input[name=featured]:checked').attr('data-filepath');
    var image_src = '../' + image_path;
    $('#featured-image-input').val(image_path);
    $('#featured-image').attr('src', image_src);
    $('#media_id').val(image_id);
  });

  // Detach modal window
  var $content = $('#gallery').detach();   // Remove modal from page

  $('#opener').on('click', function() {           // Click handler to open modal
    modal.open({content: $content, width:800, height:700});
  });
}());

var modal = (function() {                         // Declare modal object
  var $window = $(window);                        // Store the window
  var $modal = $('<div class="modal"/>');         // Create markup for modal
  var $content = $('<div class="modal-content"/>');
  var $close = $('<div class="modal-close"><button class="button">close</button></div>');

  $modal.append($content, $close);                // Add close button to modal

  $close.on('click', function(e){                 // If user clicks on close
    e.preventDefault();                           // Prevent link behavior
    $content = $('#gallery').detach();            // Remove modal from page         <<<<< this is not working for the second load of the gallery
    modal.close();                                // Close the modal window
  });

  return {                                        // Add code to modal
    center: function() {                          // Define center() method
      // Calculate distance from top and left of window to center the modal
      var top = Math.max($window.height() - $modal.outerHeight(), 0) / 2;
      var left = Math.max($window.width() - $modal.outerWidth(), 0) / 2;
      $modal.css({                                // Set CSS for the modal
        top:top + $window.scrollTop(),            // Center vertically
        left:left + $window.scrollLeft()          // Center horizontally
      });
    },
    open: function(settings) {                     // Define open() method
      $content.empty().append(settings.content);   // Set new content of modal

      $modal.css({                                 // Set modal dimensions
        width: settings.width || 'auto',           // Set width
        height: settings.height || 'auto'          // Set height
      }).appendTo('body');                         // Add it to the page

      modal.center();                              // Call center() method
      $(window).on('resize', modal.center);        // Call it if window resized
    },
    close: function() {                            // Define close() method
      $content.empty();                            // Remove content from modal
      $modal.detach();                             // Remove modal from page
      $(window).off('resize', modal.center);       // Remove event handler
    }
  };
}());