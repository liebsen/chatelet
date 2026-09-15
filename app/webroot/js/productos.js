$(document).ready(function() {
  $('.update-stock').click(function(){                
  	const btn = $(this)
  	const icon = $(this).find('i').first()
    var id = btn.attr('data-id'),
	  	url = btn.attr('data-url'),
	  	title = btn.attr('data-title'),
	  	text = btn.attr('data-text');            
    
		swal({   
			title: title,   
			text: text,   
			type: "warning",
			showCancelButton: true,   
			closeOnConfirm: true,   
			showLoaderOnConfirm: true,
		}, function() {
			icon.addClass('fa-spin')
			btn.removeClass('btn-success')
			btn.addClass('btn-warning')
			swal.close()
      $.ajax({
        url: url,
        type: 'POST',
        data: 'id='+id,
        complete: function(xhr, textStatus) {
          //called when complete
          icon.removeClass('fa-spin')
					btn.removeClass('btn-warning')
					btn.addClass('btn-success')
        },
        success: function(data, textStatus, xhr) {
        	swal(title, data.message)
        },
        error: function(xhr, textStatus, errorThrown) {
        	console.log(xhr, textStatus, errorThrown)
        	swal('Error', xhr.message)
          //called when there is an error
        }
      })
    })
  })
})