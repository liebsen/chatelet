$(document).ready(function() {

	function start_stock_sync(url, id, title, btn, icon){
		$.growl.notice({
			title: title,
			message: 'Se solicitó actualización de stock',
		});

		if(btn.attr('data-sync')) {
			return false
		}
		icon.addClass('fa-spin')
		btn.removeClass('btn-success')
		btn.addClass('btn-warning')
		btn.attr('data-sync', 1)
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
				btn.attr('data-sync', 0)
				$.growl.notice({
					title: title,
					message: 'Actualización de stock completada con éxito',
				});				
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
	}

  $('input[type="checkbox"]').click(function(){
  	var checked = false
  	$('input[type="checkbox"]').each(function(i,e){
  		if($(e).is(':checked')) {
  			checked = true
  		}
  	})
  	if(checked) {
  		$('.selection-block').removeClass('hide')
  	} else {
  		$('.selection-block').addClass('hide')
  	}
  })

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
			start_stock_sync(url, id, title, btn, icon)
    })
  })
})