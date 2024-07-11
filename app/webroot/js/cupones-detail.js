$(document).ready(function() {
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
	$('.weekdays').click(function(a) {
		let weekdays = ''
		$('.weekdays').each(function(e, i) {
			weekdays+= $(i).is(':checked') ? $(i).val() : ''
		})
		$('#weekdays').val(weekdays)
	})
});

function toggleOption(e, i){
	let data = JSON.parse(e.getAttribute('data-json'))
	let ep = $(e).hasClass('is-enabled') ? 'remove' : 'add'
	data.type = i
	data.coupon = e.getAttribute('data-coupon')
	$.post('/admin/coupon_' + ep, $.param(data))
	  .success(function(res) {
	  	let result = JSON.parse(res)
	  	console.log(result)
	  	console.log(typeof result)
	  	console.log(result.success)
	    if (result.success) {
	    	console.log('ok')
	      /*$.growl.notice({
	        title: 'Exito',
	        message: 'Se actualizó el cupón exitosamente'
	      });*/
	      $(e).removeClass('is-enabled')
	      if(ep == 'add'){
	        $(e).addClass('is-enabled')  
	      }
	    }
	  })
	  .fail(function() {
	    $.growl.error({
	      title: 'Ocurrio un error al agregar el producto al carrito',
	      message: 'Por favor, intente nuevamente'
	    });
	  });           
}