function isDateBeforeToday(date) {
    return new Date(date.toDateString()) < new Date(new Date().toDateString());
}
$(function(){
	var subtotal = $('#subtotal_compra').val();
	callStart = function(){
		$('#cost_container').removeClass('text-muted', 'text-success');
		$('#cost_container').addClass('hide');
		$('#loading').removeClass('hide');
	}

	callEnd = function(){
		cargo = 'shipment'
		$('#loading').addClass('hide');
		$('#cost_container').removeClass('hide');
		$('#cost_container').addClass('text-success');
	}

	onErrorAlert = function(text){
		$('#growls').remove();
		$.growl.error({
			title: 'Error',
			message: text
		});
	}

	onSuccessAlert = function(text){
		$('#growls').remove();
		$.growl.notice({
			title: 'OK',
			message: text
		});
	}

	formatNumber = function (num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
	}

	var timeout = null;
	var timeout2 = null;
	$('.input-cp').keyup(function(event){
		if (timeout2) {
			clearTimeout(timeout2)
		}
		let t = this
		var total_orig = $('#subtotal_compra').val()
		$('.delivery-cost').addClass('hidden')
	  event.preventDefault();
		timeout2 = setTimeout(function () {
			var url = $(t).data('url');
			var cp 	= $('.input-cp').val();
			var cost = 0
			$('#free_delivery').text('');
			$('.delivery-cost').addClass('hidden')
			callStart();
			$.getJSON( url+'/'+cp , function(json, textStatus) {
				callEnd();
				clearTimeout(timeout);
				if( json.valid ){
					$('.products-total').removeClass('hidden')
					//free delivery
					if (json.freeShipping){  
						// console.log('Envio gratis');
						// $('#subtotal_envio').val( 0 );
						// $('#free_delivery').text('Envio gratis!');
					}else{
						cost = parseInt(json.price)
						$('.delivery-cost').removeClass('hidden')
						$('.delivery-cost').addClass('fadeIn')
						$('#subtotal_envio').val(cost);
						$('#delivery_cp').text( `(${cp})` );
						$('.cost_delivery').text( formatNumber(cost));
					}
					let coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0
					let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost - coupon)
					fxTotal(total)
					$('.input-cp').removeClass('wrong');
					$('.input-cp').addClass('ok');
					onSuccessAlert('Codigo Postal válido');
				} else {
					$('.input-cp').removeClass('ok');
					$('.input-cp').addClass('wrong');
					$('#cost').text( parseInt(0) );
					fxTotal(formatNumber(total_orig))
					timeout = setTimeout( "onErrorAlert('Codigo Postal inexistente')" , 200);
				}
				$('.input-cp').attr( 'data-valid' , parseInt(json.valid) );
			});
		}, 2000)
	});

	if ($('.input-cp').val()) {
		$('.input-cp').keyup()
	}
});

window.onerror = function (msg, url, lineNo, columnNo, error) {
  onErrorAlert(`${msg}:${lineNo}`);
}
