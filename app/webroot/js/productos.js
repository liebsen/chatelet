$(document).ready(function() {

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