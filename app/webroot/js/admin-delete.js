$(document).ready(function() {
    $('.deletebutton').click(function(){                
        var id          = $(this).attr('data-id'),
        	urlback     = $(this).attr('data-url-back'),
        	delurl      = $(this).attr('data-delurl'),
        	msg         = $(this).attr('data-msg');            
        
        var r = confirm(msg);
        if (r == true){
            $.ajax({
              url: delurl,
              type: 'POST',
              data: 'id='+id,
              complete: function(xhr, textStatus) {
                //called when complete
              },
              success: function(data, textStatus, xhr) {
                window.location.href = urlback;
              },
              error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
              }
            });         
        }       
    });
});