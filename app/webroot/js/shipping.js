$(function(){
	var subtotal = $('#subtotal_compra').val();
	selectShipping = function (e, shipping, cost) {
		var coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0
		if (cost <= 0) {
			return setTimeout( "onErrorAlert('El servicio de oca no está disponible en este momento, intente en unos instantes.')" , 200);
		}

		$('.shipping-options li').removeClass('selected')
		$(e).addClass('selected')
		$('.delivery-cost').removeClass('hidden')
		$('.delivery-cost').addClass('fadeIn')
		$('#subtotal_envio').val(cost);
		$('.cost_delivery').text( formatNumber(cost));		
		$('.shipping-cargo').text(shipping)	

		let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost - coupon)
		fxTotal(total)
		onSuccessAlert(shipping.toUpperCase(), `Usted seleccionó ${shipping.toUpperCase()} como servicio de entrega`);
	}

	$('#calulate_shipping').submit(e => {
		var url = $('#calulate_shipping').data('url')
		var total_orig = $('#subtotal_compra').val()
		var cp = parseInt($('.input-cp').val())
		var cost = 0

		document.querySelector('.shipping-block').classList.add('hidden')

		$('.input-cp').removeClass('ok');				
		$('.delivery-cost').addClass('hidden')
		$('.takeaway-options li').removeClass('selected')

		if(cp < 1000 || cp > 9999) {
			onErrorAlert('Código postal inválido', `Por favor ingrese un código postal válido`);
			return false
		}

		$('#free_delivery').text('');
		$('.delivery-cost').addClass('hidden')
		callStart();
		$.getJSON( url+'/'+cp , function(json, textStatus) {
			callEnd();
			if( json.rates ){
				$('.products-total').removeClass('hidden')
				//free delivery
				if (json.freeShipping){  
					console.log('Envio gratis!')
					// $('#subtotal_envio').val( 0 );
					// $('#free_delivery').text('Envio gratis!');
				}else{
					if (json.rates) {
						var rates = `<ul class="generic-select shipping-options animated zoomInRight">`
						json.rates.forEach(rate => {
							rates+= `<li shipping="${rate.code}" onclick="selectShipping(this, '${rate.code}',${parseInt(rate.price)})"><div class="shipping-logo" style="background-image: url('${rate.image}')"><span class="text-uppercase">$${parseInt(rate.price)}</span></div></li>`
						})
						rates+= `</ul>`
						document.querySelector('.shipping-block .slot').innerHTML = rates
						$('#delivery_cp').html( `<span class="shipping-cargo is-capitalize"></span> (${cp})` );
						localStorage.setItem('lastcp', cp)		
						setTimeout(() => {
							$('.input-cp').removeClass('wrong');
							$('.input-cp').addClass('ok');
							onSuccessAlert(cp, '✓ Codigo Postal válido');
							document.querySelector('.shipping-block').classList.remove('hidden')	
							var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
							if (carrito.shipping) {
								$(`.shipping-options li[shipping="${carrito.shipping}"]`).click()
							}
						}, 750)
					} else {
						setTimeout( "onErrorAlert('Error al solicitar cotizacion. Por favor intente otra vez en unos instantes.')" , 200);
					}
				}
			} else {
				$('.input-cp').addClass('wrong');
				$('#cost').text( parseInt(0) );
				let total = formatNumber(parseFloat($('#subtotal_compra').val()) - coupon)
				fxTotal(formatNumber(total))
				setTimeout( "onErrorAlert('Codigo Postal inexistente')" , 200);
			}
			$('.input-cp').attr( 'data-valid' , json.rates.length );
		})
		return false
	})
})

window.onerror = function (msg, url, lineNo, columnNo, error) {
  onErrorAlert(`${msg}:${lineNo}`);
}
