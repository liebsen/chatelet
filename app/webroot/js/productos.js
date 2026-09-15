$(document).ready(function() {
  $('.update-stock').click(function(){                
    var id          = $(this).attr('data-id'),
	  	url = $(this).attr('data-url'),
	  	title = $(this).attr('data-title'),
	  	text = $(this).attr('data-text');            
    
		swal({   
			title: title,   
			text: text,   
			type: "warning",
			showCancelButton: true,   
			closeOnConfirm: true,   
			showLoaderOnConfirm: true,
		}, function() {
      $.ajax({
        url: urlback,
        type: 'POST',
        data: 'id='+id,
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
        	swal('Hecho', data.message)
        },
        error: function(xhr, textStatus, errorThrown) {
        	swal('Error', xhr.message)
          //called when there is an error
        }
      })
    })
  })
})