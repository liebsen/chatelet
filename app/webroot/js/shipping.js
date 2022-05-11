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
	  event.preventDefault()
		if (timeout2) {
			clearTimeout(timeout2)
		}
		let t = this
		var total_orig = $('#subtotal_compra').val()
		var cp 	= $('.input-cp').val();

		$('.input-cp').removeClass('ok');				
		$('.delivery-cost').addClass('hidden')
		$('.takeaway-options li').removeClass('selected')

		if(cp.trim() === '') {
			return false
		}

		timeout2 = setTimeout(function () {
			var url = $(t).data('url');
			var coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0
			var cost = 0
			$('#free_delivery').text('');
			$('.delivery-cost').addClass('hidden')
			callStart();
			$.getJSON( url+'/'+cp , function(json, textStatus) {
				callEnd();
				clearTimeout(timeout);
				if( json.rates ){
					$('.products-total').removeClass('hidden')
					//free delivery
					if (json.freeShipping){  
						console.log('Envio gratis!')
						// $('#subtotal_envio').val( 0 );
						// $('#free_delivery').text('Envio gratis!');
					}else{
						if (json.rates) {
							var rates = `<ul class="generic-select shipping-options">`
							Object.keys(json.rates).forEach(i => {
								const price = json.rates[i].price
								rates+= `<li shipping="${i}" onclick="selectShipping(this)" class="shipping-logo" style="background-image: url(/images/chevron_right_pink.svg), url(/images/${i}.svg)"><span class="text-uppercase">$${price}</span></li>`
							})
							rates+= `</ul>`
							document.querySelector('.shipping-block').innerHTML = rates
							document.querySelector('.shipping-block').classList.remove('hidden')
						} else {
							timeout = setTimeout( "onErrorAlert('Error al solicitar cotizacion. Por favor intente otra vez en unos instantes.')" , 200);
						}
						cost = parseInt(json.price)
						if (cost <= 0) {
							return setTimeout( "onErrorAlert('El servicio de oca no está disponible en este momento, intente en unos instantes.')" , 200);
						}
						$('.delivery-cost').removeClass('hidden')
						$('.delivery-cost').addClass('fadeIn')
						$('#subtotal_envio').val(cost);
						$('#delivery_cp').text( `(${cp})` );
						$('.cost_delivery').text( formatNumber(cost));
					}
					let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost - coupon)
					fxTotal(total)
					$('.input-cp').removeClass('wrong');
					$('.input-cp').addClass('ok');
					onSuccessAlert('Codigo Postal válido');
					localStorage.setItem('lastcp', cp)
				} else {
					$('.input-cp').addClass('wrong');
					$('#cost').text( parseInt(0) );
					let total = formatNumber(parseFloat($('#subtotal_compra').val()) - coupon)
					fxTotal(formatNumber(total))
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